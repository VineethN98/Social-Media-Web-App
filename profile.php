<style>
	.profile_left{
		top:-10px;
		width: 17%;
		max-width: 240px;
		min-width: 130px;
		height: 100%;
		float: left;
		position: relative;
		background-color: #37B0E9;
		border-right: 10px solid #83D6FE;
		color:#CBEAF8;
		margin-right: 20px;
	}

	#profile_image{
		min-width: 80px;
		width: 55%;
		margin: 20px;
		border:5px solid #83D6FE;
		border-radius: 100px;
	}

	#profile_info{
		display: list-item;
		background-color: #2980b9;
		width: 100%;
		padding: 10px 0 10px 0;
	}

	#p1{
		margin:0 0 0 20px;
		word-wrap: break-word;
	}
	#p2{
		margin:0 0 0 20px;
		word-wrap: break-word;
	}
	#p3{
		margin:0 0 0 20px;
		word-wrap: break-word;
	}
</style>


<?php 

	include 'includes/header.php';

	if(isset($_GET['profile_username'])){

		$username = $_GET['profile_username'];
		$user_details_query = mysqli_query($con, "select * from users where username = '$username'");
		$user_array = mysqli_fetch_array($user_details_query);
		$num_friends = (substr_count($user_array['friend_array'], ",")) - 1;	// Counts ',' in friend array



	}

 ?>


	<div class="profile_left">
		
		<img src="<?php echo $user_array['profile_pic']; ?>" id="profile_image">

		<div id="profile_info">
			
			<p id="p1"><?php echo "Posts: " . $user_array['num_posts'] ?></p>
			<p id="p2"><?php echo "Likes: " . $user_array['num_likes'] ?></p>
			<p id="p3"><?php echo "Friends: " . $num_friends ?></p>
			
		</div>

	</div>
	
		<div class="main_column column">
			<?php 
				echo $username;
			 ?>
			
		</div>

	</div>

</body>
</html>