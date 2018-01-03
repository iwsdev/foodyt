<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<div id="fb-root"></div>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>	
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
	<script>
$(document).ready(function(){
  
	setTimeout(function(){ 
		$("body").on("click",'.fb,.pclass', function(){
    alert("The paragraph was clicked.");
});
	}, 3000);

$("fb iframe").contents().find("button").bind("click", function () {
    alert ("test");
});
$('iframe').contents().find('button').click(function(){
    alert('hello from iframe');
})
    
});
</script>

<ul>
  <li>
    <h3>Post #1</h3>
    <div class="fb-share-button fb"  data-href="https://example.com/post/1" 
         data-layout="button"></div>  
	  
	   <div class="fb-share-button fb" data-href="https://example.com/post/1" 
         data-layout="button"></div> 
	  <p class="pclass">Click here</p>
    
  </li>
</ul>
	
</body>
</html>