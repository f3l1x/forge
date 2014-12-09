// EasyJsConfirm
$('input, a, .easyconfirm').each(function(index, el){
        var obj = $(el).data();
        if(obj.confirm){
                $(el).click(function(){
                        if(confirm(obj.confirm)){
                                return true;
                        }else{
                                return false;
                        }
                });
        }
});