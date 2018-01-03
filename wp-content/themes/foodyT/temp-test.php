<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Hello FB</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
  <meta property="og:url" content="http://bits.blogs.nytimes.com/2011/12/08/a-twitter-for-my-sister/" />
  <meta property="og:title" content="A Twitter for My Sister" />
  <meta property="og:description" content="In the early days, Twitter grew so quickly that it was almost impossible to add new features because engineers spent their time trying to keep the rocket ship from stalling." />
  <meta property="og:image" content="http://graphics8.nytimes.com/images/2011/12/08/technology/bits-newtwitter/bits-newtwitter-tmagArticle.jpg" />
</head>
<body>
<a href="https://twitter.com/share" class="twitter-share-button" data-url=" " data-count="horizontal" data-text="This is the tweet">Tweet</a>
<script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
<script type="text/javascript">
    twttr.events.bind('tweet', function(event) {
            
            console.log(event);
            alert(event.data.screen_name);
    });    
     
</script>

</body>
</html>
