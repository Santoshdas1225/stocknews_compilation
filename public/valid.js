$(function(){
    var $form =$("#form");
    if($form.length)
        {
            $form.validate({
                rules:{
                    name:{
                        required:true
                    },
                    phone:{
                        required:true,
                        number:true,
                    },
                    email:{
                        email:true
                    },
                    gender:{
                        required:true
                    },
                    age:{
                        min:18
                    },
                    file:{
                        required:true
                    },
                    password:{
                        required:true
                    },
                    cpassword:{
                        required:true,
                        equalTo:'#password'
                    }   

                },
                messages:{
                    name:{
                        required: '*Name is mandatory!'
                    },
                    email:{
                       email:'*Enter proper email id!' 
                    },
                    phone:{
                        required:'*Enter phone number!'
                        
                    },
                    cpassword:{
                        equalTo:'Should be same as password'
                    }
                }
                
            })
            
            
        }
             
});
$("document").ready(function(){
    // $("#dob").datepicker({
    //     showOtherMonths:true,
    //     selectOtherMonths:true,
    //     changeMonth:true,
    //     changeYear:true,
    //     minDate: new Date(2006,1,1),
    //     maxDate: 0,
    //     yearRange:'2005:',
    // });
    $('#phone').on('input', function() {
        var inputValue = $(this).val();
        if (inputValue.length > 10) {
            $(this).val(inputValue.slice(0, 10));
        }
        $('#phone').on('input', function() {
            var inputValue = $(this).val();
            if (inputValue.length < 10) {
                $('#errorMessage').show();
            } else {
                $('#errorMessage').hide();
            }
        });
    });
    // $('#Wnumber').on('input', function() {
    //     var inputValue = $(this).val();
    //     if (inputValue.length > 10) {
    //         $(this).val(inputValue.slice(0, 10));
    //     }
    //     $('#Wnumber').on('input', function() {
    //         var inputValue = $(this).val();
    //         if (inputValue.length < 10) {
    //             $('#werror').show();
    //         } else {
    //             $('#werror').hide();
    //         }
    //     });
    // });
    // $('input[type=radio][name=dis]').change(function() {
    //     if (this.value == 'yes') {
    //         $('#file').show();
    //     } else {
    //         $('#file').hide();
    //     }
    // });
    // $('#samenumber').change(function() {
    //     if ($(this).is(':checked')) {
    //         var mobileNumber = $('#phone').val();
    //         $('#Wnumber').val(mobileNumber);
    //     } else {
    //         $('#Wnumber').val('');
    //     }
    // })
    alertify.set('notifier','position', 'top-right');
    alertify.success('Submitted Successfully');
})
function validatesize(input)
{
    const fileSize= input.files[0].size / 1048576;
    var x= input.value.split(".");
    x=x[x.length-1].toLowerCase();
    var arrayExtensions=["txt"];
    if(arrayExtensions.lastIndexOf(x)!= -1)
        {
            alertify.notify('Invalid file format. .txt file not allowed', 'custom', 2, function(){console.log('dismissed');});
            $(input).val('');
        }
    else if(fileSize>3)
        {
            alertify.notify('File is too large.Maximum 3mb allowed', 'custom', 2, function(){console.log('dismissed');});
            $(input).val('');
        }
}
