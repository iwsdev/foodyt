<?php
/*
Template Name: Search Result Page 
*/
session_start();
get_header();



// https://plnkr.co/edit/m3jXsxsCGfqKCJYHsw0u?p=preview
// http://jsfiddle.net/eqCWL/2/

if($_REQUEST['restaurantName']){
$serachData = $_REQUEST['restaurantName'];
$_SESSION['search'] = $serachData;
$url = "/webservices/restaurant_search.php?restaurantName=".$_SESSION['search'];}

elseif($_REQUEST['location']){
$serachData = $_REQUEST['location'];
$_SESSION['search'] = $serachData;
$url = "/webservices/restaurant_search.php?location=".$_SESSION['search'];}

elseif($_REQUEST['cuisine']){
$serachData = $_REQUEST['cuisine'];
$_SESSION['search'] = $serachData;
$url = "/webservices/restaurant_search.php?cuisine=".$_SESSION['search'];}
else{
$serachData = $_REQUEST['cusine'];
$_SESSION['search'] = $serachData;
$url = "/webservices/restaurant_search.php";

}
?> 
   <style type="text/css">

       	.pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover{background-color: #f39500;
		border-color: #f39500;color:#fff;}
		.paging ul.pagination li a:hover {
		    background-color: #f39500;
		border-color: #f39500;color:#fff;
		}

       </style>
     
    <script src="https://code.angularjs.org/1.4.8/angular.js"></script>
    <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-1.0.3.js"></script>

<script>

	var siteUrl = "<?php echo site_url()?>";
	cusineListUrl = siteUrl+"/webservices/cusineList.php";
	restaurantListUrl = siteUrl+"<?php echo $url;?>";
	var myapp = angular.module('restaurantSearch', ['ui.bootstrap']);
	myapp.controller('restaurantSearchCtrl', function($scope , $http) {
               $scope.mysrclat= 0;  $scope.mysrclong = 0;
				  if (navigator.geolocation) {
				        navigator.geolocation.getCurrentPosition(function (position) {

				                $scope.mysrclat = position.coords.latitude; 
				                $scope.mysrclong = position.coords.longitude;
				                // alert(mysrclat);
				                console.log($scope.mysrclat);
				                console.log($scope.mysrclong);
				                // alert(mysrclong);
				               
				        });
				        
				    }
			   $scope.dis = [1,2,3,4,5,6,7,8,9,10];
			   $scope.page = 1;
	         //  $http.get(restaurantListUrl+"&lat=28.620764&log=77.363929")
	            $http.get(restaurantListUrl).then(function(response) {
				    $scope.restaurantList = response.data;
				    $scope.list = $scope.restaurantList.slice(0, 5);
					
					$scope.pageChanged = function() {
					  var startPos = ($scope.page - 1) * 5;
					  //$scope.displayItems = $scope.totalItems.slice(startPos, startPos + 3);
					  console.log($scope.page);
					};
				      
				  });

            $http.get(cusineListUrl)
	             .then(function(response) {
				        $scope.cusineList = response.data;
				    }); 

		   $scope.sortDesc = function(sortBy){
				 $scope.orderName = sortBy;
				 $scope.reverse = false;
			};
			$scope.sortAsc = function(sortBy){
				 $scope.orderName = sortBy;
				 $scope.reverse = true;
			};
			$scope.sortDate = function(sortBy){
				 $scope.orderName = sortBy;
				 $scope.reverse = true;
				
			};
			$scope.searchByCusine = function(sortBy){
				 $scope.listItem = sortBy;
			};

			$scope.fun = function(){
				 // console.log($scope.mysrclong);
				if($scope.mysrclong!=0){
			 //$http.get(restaurantListUrl+"&lat=28.620764&log=77.363929")
			   $http.get(restaurantListUrl+"&lat="+$scope.mysrclat+"&log="+$scope.mysrclong)
			   .then(function(response) {
				    $scope.mysrclong=0;
				    $scope.restaurantList = response.data;
				    $scope.list = $scope.restaurantList.slice(0, 5);
					$scope.pageChanged = function() {
					  var startPos = ($scope.page - 1) * 5;
					  //$scope.displayItems = $scope.totalItems.slice(startPos, startPos + 3);
					  console.log($scope.page);

					};
				      
				  });
		       }
			};

			$scope.locationFilterFunction = function(list){
				  return list.distance < $scope.selectDistance;
				 // $scope.listItem = $scope.selectDistance;
			};

});
</script>


<section id="search-result" class="search-result" ng-app='restaurantSearch'>
	<div class="container" ng-controller='restaurantSearchCtrl' ng-mouseover='fun()' >
		
		<div class="row">
			<div class="col-md-12">
				<h3><?= $_SESSION['lan']['search_list']['search_result']?>: <?php echo $_SESSION['search']; ?> </h3>
			</div>


			 

<!--  <input type="text" class="form-control" placeholder="Filter..." ng-model="listItem">
 -->
    
    


			<div class="col-md-3 search-sidebar">
					<div class="serach-ham">Filter :  <a class="toggleSearch" href="#" style="display: inline-block;"><span></span> <span></span> <span></span></a></div>
				  <div class="sidebar-wrap search-res">
					<div class="wrap sorting">
						<h4><?= $_SESSION['lan']['search_list']['sortby']?> </h4>
						<ul>
							<li><a href='' ng-click='sortDesc("title")'><?= $_SESSION['lan']['search_list']['ascTodes']?></a></li>
							<li><a  href='' ng-click='sortAsc("title")'><?= $_SESSION['lan']['search_list']['descToasc']?></a></li>
							<li><a href='' ng-click='sortDate("date")'><?= $_SESSION['lan']['search_list']['recently']?></a></li>
						</ul>
					</div>
					<div class="wrap location">
						<h4 ><?= $_SESSION['lan']['search_list']['location']?></h4>
						<ul>
							<li><?= $_SESSION['lan']['search_list']['within']?></li>

							<li>
								<!-- <select>
									<option ng-click='locationFilter("1.3285907341176852")'>0.5</option>
								</select> -->
							 <select  ng-model="selectDistance" ng-options="item for item in dis" ng-change="locationFilter = locationFilterFunction"></select>
							</li>
							<li><?= $_SESSION['lan']['search_list']['mile']?></li>
						</ul>
					</div>


					<div class="wrap cuisine">
						<h4><?= $_SESSION['lan']['search_list']['cuisine']?></h4>
						  <ul>
							  <li ng-repeat = 'cusine in cusineList | limitTo : 10'>
							  <a  href='' ng-click ='searchByCusine(cusine.cuisine_name)'>{{cusine.cuisine_name}}</a></li>
							   <li class="see-all"><a style='cursor: pointer;'g-click="loadMore()" ref="#" data-toggle="modal" data-target="#exampleModal"><?= $_SESSION['lan']['search_list']['seeall']?></a></li>

							</ul>
					</div>

				 </div>       
			</div>

			
			<div class="col-md-9">
				<div class="search-listing">
					<ul>
					    <!-- <li ng-repeat="list in restaurant = (restaurantList |filter : listItem | orderBy : orderName :  reverse)"> -->
					    <li ng-repeat="list in filterData = (restaurantList | orderBy : orderName :  reverse| filter:locationFilter | filter : listItem) | limitTo:5:5*(page-1)">
							<figure>
								<a ng-href="{{list.singlePageUrl}}" >
								<img style='max-height:115px;' src="{{list.bannerImg}}" alt="" /></a>
							</figure>
<!-- 							<p>{{list.distance}}</p>
 -->							<div class="description">
								<div class="title">
								  <h4><a ng-href="{{list.singlePageUrl}}" >{{list.title}}</a><span class="cat-title">{{list.cusine}}</span></h4>	
								</div>
								<p>{{list.content}} </p>
							</div>
						</li>

						<li class="notFound" ng-if="filterData.length === 0"><?= $_SESSION['lan']['search_list']['no_result']?>...</li>

					</ul>
				</div>


				
			<div ng-show="filterData.length">
				<div class="paging">
			        <uib-pagination class="pagination-sm pagination" total-items="filterData.length" ng-model="page"
				      ng-change="pageChanged()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=5></uib-pagination> 

					
				  </div>
				</div>
				
			</div>


			<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= $_SESSION['lan']['search_list']['select_cuision']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<ul>
		   <li ng-repeat = 'cusine in cusineList'> <a  href='' ng-click ='searchByCusine(cusine.cuisine_name)'>{{cusine.cuisine_name}}</a></li>
		</ul>
      </div>
    
    </div>
  </div>
</div>
			
			
		</div>		
	</div>
</section>


	

	
<?php get_footer();
?>
