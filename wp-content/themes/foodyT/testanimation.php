 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.5/angular.min.js"></script>
    
<article ng-app="angularSlideables">

    <h1 slide-toggle="#derp" >Click here for Hipster Ipsum.</h1>
    <div id="derp" class="slideable">
        <p>Bespoke aesthetic Bushwick craft beer. Qui aesthetic butcher, cardigan ex scenester Neutra American Apparel mumblecore.</p>
        <p>Ethical adipisicing before they sold out, sriracha Thundercats cardigan dolor deep v placeat. Flannel tattooed meggings direct trade banh mi tousled sriracha. Portland VHS ut dreamcatcher. Butcher eu irony, Banksy leggings eiusmod Pinterest hashtag Etsy asymmetrical lo-fi Helvetica quis incididunt adipisicing. YOLO cliche minim mlkshk dreamcatcher excepteur, Austin McSweeney's.</p>
        <p>Coded @ Kinfolk Studios in Williamsburg, Brooklyn, 2013.</p>
    </div>


    <h1 slide-toggle="#derp1" >Click here for Hipster Ipsum.</h1>
    <div id="derp1" class="slideable">
        <p>Bespoke aesthetic Bushwick craft beer. Qui aesthetic butcher, cardigan ex scenester Neutra American Apparel mumblecore.</p>
        <p>Ethical adipisicing before they sold out, sriracha Thundercats cardigan dolor deep v placeat. Flannel tattooed meggings direct trade banh mi tousled sriracha. Portland VHS ut dreamcatcher. Butcher eu irony, Banksy leggings eiusmod Pinterest hashtag Etsy asymmetrical lo-fi Helvetica quis incididunt adipisicing. YOLO cliche minim mlkshk dreamcatcher excepteur, Austin McSweeney's.</p>
        <p>Coded @ Kinfolk Studios in Williamsburg, Brooklyn, 2013.</p>
    </div>

    
</article>

<script type="text/javascript">
	var myApp = angular.module('angularSlideables', []);


myApp.directive('slideable', function () {
    return {
        restrict:'C',
        compile: function (element, attr) {
            // wrap tag
            var contents = element.html();
            element.html('<div class="slideable_content" style="margin:0 !important; padding:0 !important" >' + contents + '</div>');

            return function postLink(scope, element, attrs) {
                // default properties
                attrs.duration = (!attrs.duration) ? '1s' : attrs.duration;
                attrs.easing = (!attrs.easing) ? 'ease-in-out' : attrs.easing;
                element.css({
                    'overflow': 'hidden',
                    'height': '0px',
                    'transitionProperty': 'height',
                    'transitionDuration': attrs.duration,
                    'transitionTimingFunction': attrs.easing
                });
            };
        }
    };
})
myApp.directive('slideToggle', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var target = document.querySelector(attrs.slideToggle);
            attrs.expanded = false;
            element.bind('click', function() {
                var content = target.querySelector('.slideable_content');
                if(!attrs.expanded) {
                    content.style.border = '1px solid rgba(0,0,0,0)';
                    var y = content.clientHeight;
                    content.style.border = 0;
                    target.style.height = y + 'px';
                } else {
                    target.style.height = '0px';
                }
                attrs.expanded = !attrs.expanded;
            });
        }
    }
});

</script>
<style type="text/css">h1 {cursor:pointer; }</style>