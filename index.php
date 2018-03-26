<html ng-app="Bill">
<head>
    <script src="js/jquery.min.js"></script>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <script src="js/angular.min.js"></script>
    <script src="js/bootstrap.js"></script>


    <style>
	
	#cname
	{
		border-style:none;
	}
    #button {
     line-height: 20px;
     width: 80px;
     font-size: 10pt;
     margin-top: 25px;
     margin-right: 125px;
     position:absolute;
     top:0;
     right:0;
     font-family: sans-serif;
    }
    body {
  background: rgb(204,204,204); 
}
    #button1 {
     line-height: 20px;
     width: 85px;
     font-size: 10pt;
     margin-top: 25px;
     margin-right: 35px;
     position:absolute;
     top:0;
     right:0;
     font-family: sans-serif;
    }
    #table1 {
    /*border: 1px dotted black;*/
    border-spacing: 10px;
	font-size:75%;
    /*padding:10px;*/
}
	.fontsize
	{
		font-size:75%;
	}
  .border
  {
    border-bottom:1px solid;
    border-top:1px solid;
  }
    th,td
    {
      text-align: center;
padding:4px;
    }
    #style
    {
      color: green;
      font-family: sans-serif;
    }
    page {
	
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
  }
    page[size="A5"][layout="portrait"] {
      
	size: 4in;
    }
#tabsize{
	font-size:75%;
	text-align:left;
}
#tabsize1{
	font-size:75%;
	text-align:right;
}
.totalsize
{
	float:right;
	font-size:150%;
}

    @media print {
   .no-print{
        display:none;
    }
    
    #stopprint{
      page-break-inside: avoid;
      }
  }



    </style>
</head>


<body ng-controller="BillCtrl">

<!--Head Part with sign in and log out buttons-->
<div ng-show="showback"><!--Hides the initial body content and changes to bill format-->
<h3 id="style"><center>ANNAI COPIER POINT</center><input type="button" id="button" ng-show="showback" class="btn btn-danger" data-toggle="modal" data-target="#myModal" value="SIGN-IN"/><input type="button" id="button1" ng-show="notshow"  ng-click="logout()" class="btn btn-danger" value="LOG-OUT"/>
</h3>
<h4 id="style" ng-show="dontshow"><center>#1,Rangoon Street,Thousand Lights,</center></h4>
<h4 id="style" ng-show="dontshow"><center>Chennai - 600006.</center></h4>
<h4 id="style" ng-show="dontshow"><center>Ph: 2829 7444, 4231 6699</center></h4>
<h4 id="style" ng-show="dontshow"><center>Cell: 98415 70310, 99404 69381</center></h4>
<h4 id="style" ng-show="dontshow"><center>e-mail: annaicopier@gmail.com</center></h4>
<!--{{listdata}}-->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><center><b>Welcome Admin</b></center></h4>
        </div>
        <form novalidate>
        <div class="modal-body">
        <center>
          <div><strong>Username:</strong> &nbsp<input type="text" ng-model="uname" name="uname" required/></div><br/>
          <div><strong>Password:</strong> &nbsp&nbsp<input type="password" ng-model="password" name="password" required/></div>
        </center>  
        </div>
        </form>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-default" data-dismiss="modal" ng-click="checklogin()">Login</button></center>
        </div>
      </div>
    </div>
</div>

<!--Displaying Time and Date-->
<h4 class="text-primary">TIME:    <clock format="hh:mm:ss a"></clock></h4><h4 class="text-primary">DATE:   {{date | date:'dd-MM-yyyy'}}</h4>

<!--Here, we can add the public details and check out to the receipt for bill-->
<br><br>
<div class="container" ng-hide="show">
<form ng-show="dontshow" name="form" class="form-inline"><center>
<label>Select Item: </label><select ng-model="list" ng-options="list.item for list in listdata | orderBy:'item'" required> 
<option value="" disabled>-----------Choose-----------</option></select>

<label>Quantity: </label><input type="number" ng-model="item.qty" required></input>
<label>Price: </label><input ng-model="list.price" required></input>
<input type="button" value="Add to Receipt" ng-disabled="form.$invalid" class="btn btn-success" ng-click="addingtoReceipt()"></input>
</center></form></div>

<!--Table which displays the item added-->
<center><table class="table" ng-show="dontshow">
  <tr>
            <th id="table">Item Name&nbsp&nbsp</th>
            <th id="table">Qty</th>
            <th id="table">Price</th>
            <th id="table">Amount</th>
            <th></th>
  </tr>
  <tr ng-repeat="billdata in item">
      <td id="table">{{billdata.name.item}}&nbsp&nbsp</td>
      <td id="table">{{billdata.qty}}</td>
      <td id="table">{{billdata.price}}</td>
      <td id="table">{{billdata.amt | number:2}}</td>
      <td id="table" ng-show="showback"><a href ng-click="removeItem($index)"><span class="glyphicon glyphicon-remove"></span></a></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td>TOTAL: Rs{{total| number:2}}</td>
    <td><input type="button" class="btn btn-info" value="PRINTABLE MODE" ng-show="showback" ng-click="printmode()"/>&nbsp&nbsp<input type="button" class="btn btn-warning" value="RESET" ng-show="showback" ng-click="reset()"/></td>
  </tr>
</table></div></center>


<!--<center><h4 ng-hide="showback">Thank you, visit again</h4></center>

<a ng-hide="showback" ng-click="printing()">Print</a><br>
<a ng-hide="showback" ng-click="generalmode()">Back</a>-->


<!--Billing - Format, gets in when printable mode button is pressed-->

<div class="fontsize">
<page size="A5" layout="portrait" ng-show="billform">  
<center style="font-size:15px !important;"><strong>ANNAI COPIER POINT</strong></center>
<center style="font-size:13px !important;">#1,Rangoon Street,Thousand Lights,Ch-06.</center>
<center style="font-size:13px !important;">Ph: 2829 7444,98415 70310</center>
<center style="font-size:13px !important;"><span class="text-primary">TIME:    <clock format="hh:mm:ss"></clock>&nbsp</span><span class="text-primary">DATE:   {{date | date:'dd-MM-yyyy'}}</span></center>
<?php
          $con=mysql_connect("localhost","root","");

          mysql_select_db("products");
         $bno=mysql_query("Select billno from bill");
               $no=mysql_fetch_row($bno);
               echo "<font size='3'><center><strong>Bill No:$no[0]</strong></center></font>";
         
     ?>
<br><br>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span style="font-size:15px !important;">M/S:<input type="text" id="cname"/></span>
<!--Here, we can add the public details and check out to the receipt for bill-->
<div class="container" ng-hide="show">
<form ng-show="dontshow" name="form" class="form-inline"><center>
<label>Select Item: </label><select ng-model="list" ng-options="list.item for list in listdata | orderBy:'item'" required> 
<option value="" disabled>-----------Choose-----------</option></select>

<label>Quantity: </label><input type="number" ng-model="item.qty" required></input>
<label>Price: </label><input ng-model="list.price" required></input>
<input type="button" value="Add to Receipt" ng-disabled="form.$invalid" class="btn btn-success" ng-click="addingtoReceipt()"></input>
</center></form></div>

<!--Table which displays the item added-->
<br><center><table ng-show="dontshow">
  <tr class="border">
            <th id="tabsize">&nbsp&nbsp&nbsp&nbsp&nbspItem Name&nbsp&nbsp&nbsp&nbsp</th>
            <th id="tabsize">Qty&nbsp&nbsp&nbsp&nbsp</th>
            <th id="tabsize">Price</th>
            <th id="tabsize">Amount</th>     
  </tr>
  <tr ng-repeat="billdata in item">
      <td id="tabsize">&nbsp&nbsp&nbsp&nbsp&nbsp{{billdata.name.item}}&nbsp&nbsp&nbsp&nbsp</td>
      <td id="tabsize1">{{billdata.qty}}&nbsp&nbsp&nbsp&nbsp</td>
      <td id="tabsize1">{{billdata.price}}</td>
      <td id="tabsize1">{{billdata.amt|number:2}}</td>
  </tr>
</table></center><br><br>
<div class="totalsize">TOTAL Rs: {{total|number:2}}&nbsp&nbsp&nbsp&nbsp</div><br><br>
<center><h5 id="stopprint" ng-hide="showback">Thank you, visit again</h5></center>
<a class="no-print" ng-hide="showback" ng-click="printing()">Print</a><br>
<a class="no-print" ng-hide="showback" ng-click="generalmode()">Back</a>
</page>
</div>

<!--Adding Product Items Details to the Database-->
<center>
<form name="validate" method="post" action="push.php" ng-show="adminshow">
<h4 id="style">ADD NEW PRODUCT</h4>
<br><br>
<div><input type="text" name="item" placeholder="Item Name" required></input></div><br>
<div><input type="number" name="price" placeholder="Price" required></input></div><br>
<div><input type="submit" ng-disabled="validate.$invalid" class="btn btn-primary" value="Add"></input></div>
</form>
<br><br>

<!--Updating Product Details to the Database-->
<form name="update" method="post" action="updateprice.php" ng-show="adminshow" required>
<h4 id="style">UPDATE PRODUCT PRICE</h4>
<br><br>
<strong> Select Product : </strong> 
<select name="prodName"> 
       <option value="" disabled> -----------Choose----------- </option> 
     <?php
          $con=mysql_connect("localhost","root","");

          mysql_select_db("products");
         $rows=mysql_query("Select item from details");
         while($r=mysql_fetch_row($rows))
         { 
               echo "<option value='$r[0]'> $r[0] </option>";
         }
     ?>
</select>
<br><br>
<strong>Price : </strong><input type="number" name="newprice" placeholder="New Price" required></input><br><br>
<input type="submit" class="btn btn-info" ng-disabled="update.$invalid" value="Update"></input>
</center>
</form>
</body>



<!--Angularjs code and its manipulation-->

<script>
  var app=angular.module('Bill', []);
  app.controller('BillCtrl',['$scope','$http',  function($scope,$http){

    $scope.total=0;
    $scope.item=[];
    $scope.listdata=[];
    $scope.show=false;
    $scope.dontshow=true;
    $scope.showback=true;
    $scope.billform=false;
    $scope.date = new Date();

    /*Username and Password for Admin*/
    $scope.uname="annaicopier";
    $scope.chckpname="annai310";

    //Get the item and its price datas from the DB and store in listdata
    $http({method: 'GET', url: 'get.php'}).success(function(result){
      $scope.listdata=result;
    });



    //Checking the admin login's 
    $scope.checklogin=function()
    {
      if(($scope.uname==$scope.uname) && ($scope.password==$scope.chckpname))
      {
        //$scope.uname="";
        $scope.password="";
        $scope.adminshow=true;
        $scope.notshow=true;
        $scope.dontshow=false;
      }
      else
      {
        alert("Username or password is wrong");
        $scope.uname="";
        $scope.password="";
      }

    }

    $scope.addingtoReceipt=function()
    {

      $scope.item.push({name:$scope.list,qty:$scope.item.qty,price:$scope.list.price,amt:$scope.item.qty*$scope.list.price});
      $scope.total=$scope.total+($scope.item.qty*$scope.list.price);
      
      $scope.list="";
      $scope.list.price="";
      $scope.item.qty="";
    }

    
    $scope.logout=function()
    {
      $scope.notshow=false;
      $scope.adminshow=false;
      $scope.dontshow=true;
    }

    $scope.removeItem = function(index) {
      $scope.total=$scope.total-($scope.item[index].amt);
        $scope.item.splice(index, 1);
    }

    $scope.printmode=function()
    {
      $scope.show=true;
      $scope.showback=false;
      $scope.billform=true;
    }
    $scope.generalmode=function()
    {
      $scope.show=false;
      $scope.showback=true;  
      $scope.billform=false;
    }
    $scope.printing=function()
    {
      window.print();
	$http({method: 'GET', url: 'getbillno.php'}).success(function(){
    });
    }
    $scope.reset=function()
    {
      $scope.item.splice($scope.item);
      $scope.total=0;
    }
  }]);
  app.directive('clock', ['dateFilter', '$timeout', function(dateFilter, $timeout){
    return {
        restrict: 'E',
        scope: {
            format: '@'
        },
        link: function(scope, element, attrs){
            var updateTime = function(){
                var now = Date.now();
                
                element.html(dateFilter(now, scope.format));
                $timeout(updateTime, now % 1000);
            };
            
            updateTime();
        }
    };
}]);

</script>

</html>