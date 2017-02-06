<!DOCTYPE html>
<!--

-->
<html>
	<head>
	<meta charset="utf-8">
	<title></title>
	<style>
							
		ul {
   			list-style-type: none;
    			margin: 0;
    			padding: 0;
   			overflow: hidden;
    			border: 1px solid #e7e7e7;
    			background-color: #f3f3f3;
		}

		li {
   			float: left;
		}

		li a {
   			display: block;
   			color: #666;
 			text-align: center;
  			padding: 14px 16px;
   			text-decoration: none;
		}

		li a:hover:not(.active) {
    			background-color: #aaa;
		}

		li a.active {
   			color: white;
   			background-color: #1051ba;
		}

		ul{
			text-align: center; 
    			position: fixed; 
			top: 0;
 			left: 0;
 			float: left;    
 			margin: 0;
  			padding: 0;
  			list-style-type: none;
		}
		.footer {
 			position: absolute;
  			right: 0;
  			bottom: 0;
  			left: 0;
  			padding: 1rem;
  			background-color: #efefef;
  			text-align: center;
		}
		.header {
			width: 100%; 
		}
		.content {
			padding-bottom:100px; /* Height of the footer element */
		}

	</style>

	</head>
	<body>
		<ul class = "header">
			<li><a href="/hackweek/journal.php?user=<?php echo $_SESSION['username'];?>">Home</a></li> <!-- link back to journal page --> 
			<li style = "float:right"><a href="logout.php">Logout</a></li>  <!-- go though logout page and then go to login page -->
		</ul>
	</body>
</html>