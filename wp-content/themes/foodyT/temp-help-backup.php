<?php

get_header();
?>



    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-animate.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-sanitize.js"></script>
    <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.5.0.js"></script>
    <script src="example.js"></script>

     <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap1.min.css">

 <section id="help" class="help" ng-app="ui.bootstrap.demo" ng-controller="AccordionDemoCtrl">

   <script type="text/ng-template" id="group-template.html">

    <div class="panel-heading" ng-click="toggleOpen()" >
      <h4 class="panel-title" style="color:#000">
        <a href tabindex="0" class="accordion-toggle"  uib-accordion-transclude="heading" > 
          <span uib-accordion-header ng-class="{'text-muted': isDisabled}">
           </span>
        </a>
      </h4>
    </div>
    <div class="panel-collapse collapse" uib-collapse="!isOpen">
      <div class="panel-body" style="text-align: left" ng-transclude></div>
    </div>

    
  </script>

	<div class="container">
       <div class="row">

			<div class="col-md-6">
				<h3 class="title"> <?= $_SESSION['lan']['help'][0]?></h3>
			</div>
			
			<div class="col-md-6">
				<div class="faq-search">
					<i class="fa fa-search"></i>
					<input type="search" class="search"  ng-model="test" placeholder=" <?= $_SESSION['lan']['help'][1]?>"/>
				</div>
			</div>
			</div>
		 <div class="row">
    <div class="col-md-12 tabs">
					  <ul>
						  <uib-accordion close-others="oneAtATime">
							<!--  <div uib-accordion-group class="panel-default" heading="{{group.title}}" ng-repeat="group in myHelpPost | filter:test">
							      {{group.content}}
							 </div>
 -->

							 <!-- <div uib-accordion-group class="panel-default" heading="Custom template" template-url="group-template.html" ng-repeat="group in myHelpPost | filter:test">
						        {{group.content}}
						    </div> -->

	<div uib-accordion-group class="panel-default"   is-open="false" template-url="group-template.html" ng-repeat="group in myPost = (myHelpPost | filter:test)">
		      <uib-accordion-heading>
		       {{group.title}} <i  class="fa fa-plus" id="iconId" style="float: right;"></i>
		      </uib-accordion-heading>
		     {{group.content}}
		    </div>
    <li class="notFound" ng-if="myPost.length === 0">No Search Found!...</li>

		    </uib-accordion>



					 </ul>
			   </div>

			  </div>
	   
 
		</div>		
	</div>
</section>


<?php 
get_footer();
?>
<script>
var siteUrl = "<?php echo site_url()?>";
helpListUrl = siteUrl+"/webservices/help.php";
angular.module('ui.bootstrap.demo', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);
angular.module('ui.bootstrap.demo').controller('AccordionDemoCtrl', function ($scope,$http) {



    $http.get(helpListUrl)
    .then(function(response) {
        $scope.myHelpPost = response.data;
    });

// below code are used to open slide multiple at a time
	  $scope.status = {
	    isCustomHeaderOpen: true,
	    isFirstOpen: true,
	    isFirstDisabled: true
	  };
	
	  
});
</script>
<script type="text/javascript">
	 $( document ).ready(function() {
	    setTimeout(function(){ $('.panel-default').on('click',function(){
     	  $(this).find('#iconId').toggleClass('fa-minus');
           
    }); }, 1000);
     
  });
</script>

