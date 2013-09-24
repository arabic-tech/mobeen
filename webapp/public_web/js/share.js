function fbs_click(u, t) {
//var w = (window.open(urlstring, wname, wfeatures, false));
window.open('http://www.facebook.com/sharer.php?u='+u+'&t='+encodeURIComponent(t),'share','toolbar=0,status=0,width=640,height=480');
//alert('عذرا، فهذه الخدمة مازالت تحت التطوير وليست متوفرة بعد.');
return false;
}

function tws_click(u, t) {
window.open('http://twitter.com/home?status='+t+' '+u,'share','toolbar=0,status=0,width=640,height=480');
//alert('عذرا، فهذه الخدمة مازالت تحت التطوير وليست متوفرة بعد.');
return false;
}

function gbz_click(u, t) {
window.open('http://www.google.com/buzz/post?url='+u+'&title='+t+'&type=normal-count','share','toolbar=0,status=0,width=640,height=480');
return false;
}


function email_click(u, t) {
//alert('عذرا، فهذه الخدمة ليست مبوفرة بعد وما زالت قيد التطوير.');
alert('عذرا، فهذه الخدمة مازالت تحت التطوير وليست متوفرة بعد.');
return false;
}

function print_click(u, t) {
//alert('hello print');
//alert('عذرا، فهذه الخدمة مازالت تحت التطوير وليست متوفرة بعد.');
window.open(u+'?print=true','print','toolbar=0,status=0,width=640,height=480,scrollbars=1');
//window.print();
return false;
}

