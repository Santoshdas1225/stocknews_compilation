<?php

namespace App\Http\Controllers;
use App\Models\Allnews;
use DateTime;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    public function fetchdata($url,$model,$src)
    {
    
         
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
    
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            abort(500, 'Error in fetching: ' . curl_error($ch));
        } else {
            $xml = simplexml_load_string($response);
    
            foreach ($xml->channel->item as $item) {
                $media_url = null;
    
                
                if (isset($item->children('media', true)->content->attributes()->url)) {
                    $media_url = (string)$item->children('media', true)->content->attributes()->url;
                }
                
                elseif (isset($item->enclosure) && isset($item->enclosure['url'])) {
                    $media_url = (string)$item->enclosure['url'];
                }
                else {
                    if($src=='zeebusiness')
                    {
                        $media_url = url('zeebusiness.jpg');
                    }
                    elseif($src=='MONEYCONTROL')
                    {
                        $media_url = url('moneycontrol.png');
                    }
                    
                }

                // change start
                $pubDate = (string)$item->pubDate;

                
            preg_match('/(\d{2}):(\d{2}):(\d{2})/', $pubDate, $timeParts);
            $hour = (int)$timeParts[1];
            $minute = $timeParts[2];
            $second = $timeParts[3];

            
            if ($hour >= 24) {
                $hour = '00';
               
                $pubDate = preg_replace('/\d{2}:\d{2}:\d{2}/', "$hour:$minute:$second", $pubDate);
               
                $dateTime = new DateTime($pubDate);
                //$dateTime->modify('+1 day');
                $pubDate = $dateTime->format(DateTime::RFC2822);
            }
            // change end
            $contentString=null;
            $herf = (string)$item->link;
            if($src == 'LiveMint')
            {
                $articleDetails = $this->fetchlivemintcontent($herf);
        
                $content = $articleDetails['content'];
                $contentString = implode(' ', $content);
                // echo (string)$item->link;
                // echo  $contentString;
                // dd($contentString);
                // exit();  
            }
            elseif($src == 'thehindu')
            {
                $articleDetails = $this->fetchhinducontent($herf);
        
                $content = $articleDetails['content'];
                $contentString = implode(' ', $content);
            }
            elseif($src == 'CNBCTV18')
            {
                $articleDetails = $this->fetchCNBCcontent($herf);
        
                $content = $articleDetails['content'];
                $contentString = implode(' ', $content);
            }
       



                    $existingdata = $model::where('title', (string)$item->title)->first();
    
                    if (!$existingdata) {
                        $news = new $model();
                        $news->date = date('Y-m-d H:i:s', strtotime($pubDate));
                        $news->title = (string)$item->title;
                        $news->link = (string)$item->link;
                        $news->source = $src;
                      
                        $news->content =  $contentString; 
                        
                        
                        $news->media_url = $media_url; 
                        $news->save();
                    }
                
            }
             $news = $model::orderBy('date','desc')->latest()->get();

             return $model::orderBy('date','desc')->get(); 
         }
        
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////
    private function fetchlivemintcontent($href)
    {
        // Initialize cURL to fetch the article page
        ini_set('max_execution_time', 0); 
        $ch = curl_init($href);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
    
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            abort(500, 'Error fetching data: ' . curl_error($ch));
        }
    
        curl_close($ch);
    
        // Parse the HTML content
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($response);
        libxml_clear_errors();
    
        $xpath = new DOMXPath($dom);
        // XPath query to find the publication date and time
        // $queryContent = "//div[contains(@class,'storyPage_storyContent__m_MYl')]";

        $queryContent = [
            '//div[contains(@class,"storyPage_storyContent__m_MYl")]',
            '//div[contains(@class,"liveSecIntro")]',
         
        ];
    
        $content = [];
        
        
        foreach ($queryContent as $query) {
            $contentNodes = $xpath->query($query);
        
            foreach ($contentNodes as $node) {
                // Check if the node is from the first query
                if (strpos($query, 'storyPage_storyContent__m_MYl') !== false) {
                    $paragraphs = $xpath->query('.//div[contains(@class,"storyParagraph")]', $node);
                } 
                // Check if the node is from the second query
                elseif (strpos($query, 'liveSecIntro') !== false) {
                    $paragraphs = $xpath->query('.//p', $node); // Query for <p> tags within the current node
                }
        
                // Collect the content
                foreach ($paragraphs as $paragraph) {
                    $content[] = trim($paragraph->nodeValue);
                }
            }
        }


        // foreach ($contentNodes as $node) {
        //     // Query for storyParagraph divs within each storyPage_storyContent__m_MYl node
        //     $paragraphs = $xpath->query('.//div[contains(@class,"storyParagraph")]', $node);
            
        //     foreach ($paragraphs as $paragraph) {
        //         $content[] = trim($paragraph->nodeValue); // Collect and trim the paragraph content
        //     }
        // }
    
        return [
            'content' => $content,
        ];
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////
private function fetchhinducontent($href)
{
    // Initialize cURL to fetch the article page
    ini_set('max_execution_time', 0); 
    $ch = curl_init($href);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        abort(500, 'Error fetching data: ' . curl_error($ch));
    }

    curl_close($ch);

    // Parse the HTML content
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($response);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    // XPath query to find the publication date and time
     $queryContent = "//div[contains(@class,'articlebodycontent ')]";

    // $queryContent = [
    //     '//div[contains(@class,"storyPage_storyContent__m_MYl")]',
    //     '//div[contains(@class,"liveSecIntro")]',
     
    // ];

    $content = [];
    
    
    // foreach ($queryContent as $query) {
    //     $contentNodes = $xpath->query($query);
    
    //     foreach ($contentNodes as $node) {
    //         // Check if the node is from the first query
    //         if (strpos($query, 'storyPage_storyContent__m_MYl') !== false) {
    //             $paragraphs = $xpath->query('.//div[contains(@class,"storyParagraph")]', $node);
    //         } 
    //         // Check if the node is from the second query
    //         elseif (strpos($query, 'liveSecIntro') !== false) {
    //             $paragraphs = $xpath->query('.//p', $node); // Query for <p> tags within the current node
    //         }
    
    //         // Collect the content
    //         foreach ($paragraphs as $paragraph) {
    //             $content[] = trim($paragraph->nodeValue);
    //         }
    //     }
    // }

    $contentNodes = $xpath->query($queryContent);
    foreach ($contentNodes as $node) {
        
        $paragraphs = $xpath->query('.//p', $node);
        
        foreach ($paragraphs as $paragraph) {
            $content[] = trim($paragraph->nodeValue); // Collect and trim the paragraph content
        }
    }

    return [
        'content' => $content,
    ];
}
/////////////////////////////////////////////////////////////////////////////////////////////////////


    private function fetchCNBCcontent($href)
    {
    // Initialize cURL to fetch the article page
    ini_set('max_execution_time', 0); 
    $ch = curl_init($href);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        abort(500, 'Error fetching data: ' . curl_error($ch));
    }

    curl_close($ch);

    // Parse the HTML content
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($response);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    // XPath query to find the publication date and time
     $queryContent = "//div[contains(@class,'articleWrap')]";
     $contentNodes = $xpath->query($queryContent);

    $content = [];
    
    
    

    foreach ($contentNodes as $node) {
        // Fetch the content directly from the div
        $content[] = trim($node->nodeValue); // Collect and trim the content directly from the div
    }

    return [
        'content' => $content,
    ];
}

    //////////////////////////////////////////////////////////////////////////////////////////////////
    public function fetchmoneycontrol($url, $modelclass, $src)
    {
    // Initialize cURL to fetch the list of articles
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        abort(500, 'Error fetching data: ' . curl_error($ch));
    }

    curl_close($ch);

    // Parse the HTML content
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($response);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    // XPath query to find the list of articles
    $nodes = $xpath->query('//li[contains(@class, "clearfix")]');

    foreach ($nodes as $node) {
        $aTag = $xpath->query('.//a', $node)->item(0);

        if ($aTag) {
            $title = $aTag->getAttribute('title');
            $href = $aTag->getAttribute('href');
            $imgTag = $xpath->query('.//img', $aTag)->item(0);

            if ($imgTag) {
                $imgSrc = $imgTag->getAttribute('data');
                $imgSrc = explode('?', $imgSrc)[0]; 
            } else {
                $imgSrc = 'N/A';
            }
        } else {
            $title = 'N/A'; 
            $href = 'N/A'; 
            $imgSrc = url('moneycontrol.png');
        }

        // Fetch the publication date and time from the detailed article page
        $articleDetails = $this->fetchdatetime($href);
        $time = $articleDetails['time']; // Use current time if time is null
        $content = $articleDetails['content'];
        $contentString = implode(' ', $content);
        // echo $contentString;
        // dd($content);
        // exit();
        // Check if the news item already exists based on title or link
        $existingdata = $modelclass::where('title', $title)->orWhere('link', $href)->first();

        if (!$existingdata) {
            $newsItem = new $modelclass();
            $newsItem->date = $time;
            $newsItem->title = $title;
            $newsItem->link = $href;
            $newsItem->media_url = $imgSrc;
            $newsItem->source = $src;
            // $newsItem->content = $contentString;

            $newsItem->save();
        } else {
            Log::info("News Already Exists: $title");
        }
    }

    return $modelclass::orderBy('date', 'desc')->get();
}



///////////////////////////////////////////////////////////////////////////////////////////////////////

private function fetchdatetime($href)
{
    // Initialize cURL to fetch the article page
    ini_set('max_execution_time', 0); 
    $ch = curl_init($href);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        abort(500, 'Error fetching data: ' . curl_error($ch));
    }

    curl_close($ch);

    // Parse the HTML content
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($response);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    // XPath query to find the publication date and time
    $queryTime = "//div[contains(@class,'article_schedule')]";
    $queryContent = [
        '//*[@id="div_app_container"]',
        '//*[@id="contentdata"]',
     
    ];
    

    $time = null;
    $dateNode = $xpath->query($queryTime)->item(0);

    if ($dateNode) {
        $publicationDate = trim($dateNode->nodeValue);
        
        Log::info("Raw Date String: $publicationDate");

        if ($publicationDate) {
            // Remove the "IST" part and the "/" separator
            $publicationDate = str_replace(' IST', '', $publicationDate);
            $publicationDate = str_replace(' / ', ' ', $publicationDate);
        
            // Debug: Output the modified date string
            Log::info("Modified Date String: $publicationDate");
        
            // Convert the time to the desired format
            $dateTime = \DateTime::createFromFormat('F d, Y H:i', $publicationDate);
          
            if ($dateTime) {
                // Convert to the desired format
                $time = $dateTime->format('Y-m-d H:i:s');
               
                Log::info("Parsed Date: $time");
            } else {
                Log::error("Date Parsing Failed for: $publicationDate");
               
            }
        }
    }  

    
    $content = []; 

    foreach ($queryContent as $query) {
    $contentNodes = $xpath->query($query);
    
    foreach ($contentNodes as $node) {
        $paragraphs = $xpath->query('.//p', $node); // Query for <p> tags within the current node
        
        foreach ($paragraphs as $paragraph) {
            $content[] = trim($paragraph->nodeValue); // Collect paragraph content
        }
    }
}

    return [
        'time' => $time,
        'content' => $content,
    ];
}
///////////////////////////////////////////////////////////////////////////////////////////////////////







////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function fetchzeebiz($url,$modelclass,$src)
{
    ini_set('max_execution_time', 0); 

    $zurl = $url;
    $defaultImage = url('zeebusiness.jpg'); 
    $currentTime = date('Y-m-d H:i:s'); 

    $ch = curl_init($zurl);
    curl_setopt($ch, CURLOPT_URL, $zurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        abort(500, 'Error fetching data: ' . curl_error($ch));
    }

    curl_close($ch);

    
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($response);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $queries = [
        '//div[contains(@class, "eventtracker")]/div[contains(@class, "view")]/div[contains(@class, "view-content")]/div/div[contains(@class, "borrgtgry2 ")]/h3/a',
        '//div[contains(@class, "eventtracker")]/div/h3[contains(@class, "lead-head3")]/a',
        '//div[contains(@class, "bxborcontr")]/div[contains(@class, "eventtracker")]/div/h3[contains(@class, "image-heading-hp")]/a',
        '//*[@id="markets"]/div[2]/div[2]/div/div/div/div/h3/a',
        '//*[@id="economy"]/div[2]/div[2]/div/div/div/div/h3/a',
        '//*[@id="tech-gadegt"]/div[2]/div[2]/div/div/div/div/h3/a',
        '//*[@id="automobiles"]/div[2]/div[2]/div/div/div/div/h3/a',
        '//*[@id="industry"]/div[2]/div[2]/div/div/div/div/h3/a',
        '//*[@id="lifestyle"]/div[2]/div[2]/div/div/div/div/h3/a'
    ];

    $newsItems = [];
    foreach ($queries as $query) {
        $nodes = $xpath->query($query);
        $nodeCount = $nodes->length;
        echo "Found $nodeCount nodes for query: $query\n"; // Debug line

        foreach ($nodes as $node) {
            $title = trim($node->nodeValue);
            $href = $node->getAttribute('href');
            if (strpos($href, 'http') !== 0) {
                $href = rtrim($zurl, '/') . '/' . ltrim($href, '/');
            }

            $articleDetails = $this->fetchArticleDetails($href);
            $time = $articleDetails['time'] ?? $currentTime; // Use current time if time is null
            $img = $articleDetails['img'] ?? $defaultImage; // Use default image if img is null

            $newsItems[] = [
                'title' => $title,
                'link' => $href,
                'time' => $time,
                'img' => $img,
                'source' => 'zeebusiness'
            ];

            $existingdata = $modelclass::where('title', (string)$title)->first();
            if(!$existingdata)
            {
            $newsItem = new $modelclass();
            $newsItem->date = $time;
            $newsItem->title = $title;
            $newsItem->link = $href;
            $newsItem->source = $src; 
            $newsItem->media_url = $img; 
            $newsItem->save(); 
           }
        }
    }

    return $modelclass::orderBy('date','desc')->get();
}

                            /////////////////////////////////////////

    private function fetchArticleDetails($href)
    {
    
    $urlSegments = explode('-', basename(parse_url($href, PHP_URL_PATH)));
    $id = end($urlSegments);

    $ch = curl_init($href);
    curl_setopt($ch, CURLOPT_URL, $href);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        abort(500, 'Error fetching data: ' . curl_error($ch));
    }

    curl_close($ch);

    
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($response);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $queryTime = "//*[@id=\"$id\"]/div[1]/div[3]/div/div[2]/div/span/div[@class='date']";
    $queryImg = "//*[@id=\"$id\"]/div[1]/div[2]/div/img";

    
    $nodesTime = $xpath->query($queryTime);
    $time = $nodesTime->length > 0 ? trim($nodesTime->item(0)->nodeValue) : null;

    if ($time) {
        
        $time = preg_replace('/^Updated:\s\w+,\s/', '', $time);

        
        $dateTime = \DateTime::createFromFormat('M d, Y h:i A T', $time);
        if ($dateTime) {
            $time = $dateTime->format('Y-m-d H:i:s');
        } else {
            
            $time = null;
        }

    
    $nodesImg = $xpath->query($queryImg);
    $img = $nodesImg->length > 0 ? trim($nodesImg->item(0)->getAttribute('src')) : null;

    if ($img) {
        
        $img = explode('?', $img)[0];
    }

        return [
            'time' => $time,
            'img' => $img
        ];
    }

    }

/////////////////////////////////////////   

    ///////////////////////////////////////////////////////////////////////////////////////////////////
    public function insertdata()
    {
        $allNewsCollection = collect();
        // $lurl = 'https://www.livemint.com/rss/markets'; 
        // $news = $this->fetchdata($lurl, Allnews::class, 'LiveMint');
        // $allNewsCollection = $allNewsCollection->merge($news);

        // $murl= 'https://www.moneycontrol.com/news/business/';
        // $news = $this->fetchmoneycontrol($murl,Allnews::class,'MONEYCONTROL');
        // $allNewsCollection = $allNewsCollection->merge($news);

        // $zurl='https://www.zeebiz.com/';
        // $news = $this->fetchzeebiz($zurl,Allnews::class,'zeebusiness');
        // $allNewsCollection = $allNewsCollection->merge($news);

        // $hurl='https://www.thehindu.com/business/feeder/default.rss';
        // $news= $this->fetchdata($hurl, Allnews::class,'thehindu');
        // $allNewsCollection = $allNewsCollection->merge($news);

        $curl='https://www.cnbctv18.com/commonfeeds/v1/cne/rss/market.xml';
        $news= $this->fetchdata($curl, Allnews::class,'CNBCTV18');
        $allNewsCollection = $allNewsCollection->merge($news);

        return redirect('allnews');
    }
    

    /////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function alldata(Request $request)
    {
        $alldata = Allnews::all()->sortByDesc('date');
        $topnews = Allnews::whereNotNull('media_url')->orderBy('date', 'desc')->take(5)->get();
        $trnews = Allnews::whereNotNull('media_url')->orderBy('date', 'desc')->take(10)->get();
        
        $today = date('Y-m-d');
        $todaynews = Allnews::whereNotNull('media_url')
                            ->where('date', 'LIKE', $today . '%')
                            ->orderby("date","DESC")
                            ->paginate(10);
        
        $yesterdaynews = Allnews::whereNotNull('media_url')
                                ->whereDate('date', today()->subDay())
                                ->orderby("date","DESC")
                                ->paginate(10);
    
        if ($request->ajax()) {
            if ($request->type == 'today') {
                $view = view('todaynew', compact('todaynews'))->render();
            } else if ($request->type == 'yesterday') {
                $view = view('yesterday', compact('yesterdaynews'))->render();
            }
    
            return response()->json(['html' => $view]);
        }

            
        return view('home1', compact('alldata', 'topnews', 'trnews', 'todaynews', 'yesterdaynews'));
    }
    

   /////////////////////////////////////////////////////////////////////////////////////////////////////
    public function yesterday(Request $request)
    {
        $yesterdaynews= Allnews::whereNotNull('media_url')
                         ->whereDate('date',today()->subday())
                         ->paginate(10);

        return view('yesterday' , compact('yesterdaynews') );

    }



   ////////////////////////////////////////////////////////////////////////////////////////////////////////

   

   public function moneycontroldashboard(Request $request)
   {

    
        $scr= 'MONEYCONTROL';
        $moneycontrol= Allnews::whereNotNull('media_url')->where('source',$scr)->orderBy('date', 'desc')->paginate(10);
        if ($request->ajax()) {
            $view = view('moneycontrolshow', compact('moneycontrol'))->render();
    
            return response()->json(['html' => $view]);
        } 

        return view('moneycontroldashboard', compact('moneycontrol'));
   }

   public function thehindudashboard(Request $request)
   {
        $scr= 'thehindu';
        $hindu= Allnews::whereNotNull('media_url')->where('source',$scr)->orderBy('date', 'desc')->paginate(10);
        if ($request->ajax()) {
            $view = view('thehindushow', compact('hindu'))->render();
    
            return response()->json(['html' => $view]);
        } 
        return view('thehindudashboard', compact('hindu'));
   }


   public function livemint(Request $request)
   {
        $scr= 'LiveMint';
        $lm= Allnews::whereNotNull('media_url')->where('source',$scr)->orderBy('date', 'desc')->paginate(10);
        if ($request->ajax()) {
            $view = view('livemintshow', compact('lm'))->render();
    
            return response()->json(['html' => $view]);
        } 

        return view('livemintdashboard', compact('lm'));
   }

   public function zeebusiness(Request $request)
   {
        $scr= 'zeebusiness';
        $zeebusiness= Allnews::whereNotNull('media_url')->where('source',$scr)->orderBy('date', 'desc')->paginate(8);
        if ($request->ajax()) {
            $view = view('zeebusinessshow', compact('zeebusiness'))->render();
    
            return response()->json(['html' => $view]);
        } 
        return view('zeebusinessdashboard', compact('zeebusiness'));
   }

   //////////change
   public function CNBCTV18(Request $request)
   {
        $scr= 'CNBCTV18';
        $lm= Allnews::whereNotNull('media_url')->where('source',$scr)->orderBy('date', 'desc')->paginate(10);
        if ($request->ajax()) {
            $view = view('CNBCTV18show', compact('lm'))->render();
    
            return response()->json(['html' => $view]);
        } 

        return view('CNBCTV18dashboard', compact('lm'));
   }



   public function all(Request $request)
   {
        
        $all= Allnews::whereNotNull('media_url')->orderBy('date', 'desc')->paginate(10);
        
        if ($request->ajax()) {
            $view = view('all1', compact('all'))->render();
    
            return response()->json(['html' => $view]);
        }                  
        return view('all', compact('all'));
   }
   //////////////////////////////////////////////////////////////////////////////////////////////

   public function header()
   {
        $data=Allnews::all();
        return view('header', compact('data'));
    }

    //////////////////////////////////////////////////////////////////////////////////////////////

    public function contactus()
    {
        return view('contactus');
    }

    public function privacypolicy()
    {
        return view('privacypolicy');
    }




    public function fetchNews()
    {
        $response = Allnews::all();
        return response()->json($response);
    
    }
}



