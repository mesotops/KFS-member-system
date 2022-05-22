<?php
	//載入 db.php 檔案，讓我們可以透過它連接資料庫
	require_once 'db.php';
	
?>
<!DOCTYPE html>
<html lang="zh-TW">
	<head>
		<title>刪除資料 DELETE，刪除資料表中的資料</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<!-- 給行動裝置或平板顯示用，根據裝置寬度而定，初始放大比例 1 -->	
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- 載入 bootstrap 的 css 方便我們快速設計網站-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
		
	</head>

	<body>
		<!-- div 類別為 container-fluid 代表是滿版的區塊 -->
		<div class="container-fluid">
			<!-- 建立第一個 row 空間，裡面準備放格線系統 -->
			<div class="row">
				<!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
				<div class="col-xs-12">
					<button><a href="index.html">首頁</a></button> 
					<h2>DELETE 刪除</h2>
					<div class="well well-sm">
						<form action="delect.php" method="post">
							欲刪除學號查詢:<input type="varchar" name="id">
							<input type="submit" name="select" value="查詢">
						</form>
					</div>				
					
					<div class="well well-sm">
						<?php 
						//定義一個 $datas 陣列變數，準備要放查詢的資料                              
						$datas = array();     
						$id = $_POST['id'];
						$test=1;           
				  
						//將查詢語法當成字串，記錄在$sql變數中
						$sql = "SELECT * FROM `member` WHERE `id` like '{$id}';";
			
						//用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
						$result = mysqli_query($link, $sql);
			
						//如果請求成功
						if ($result)
						{
						  //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
						  if (mysqli_num_rows($result) > 0)
						  {
							//取得的量大於0代表有資料
							//while迴圈會根據查詢筆數，決定跑的次數
							//mysqli_fetch_assoc 方法取得 一筆值
							while ($row = mysqli_fetch_assoc($result))
							{
							  $datas[] = $row;
							}
						  }
			
						  //釋放資料庫查詢到的記憶體
						  mysqli_free_result($result);
						}
						else
						{
						  echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($link);
						}
			
						if (!empty($datas))
						{
						  //如果 $datas 不是空的，就用print_r印出 $datas
						  // print_r($datas);
						}
						else
						{
						  //為空的，代表沒資料
						  // echo "查無資料";
						}
						?>
						<?php if(isset($_POST['select'])):?>							
							<?php foreach($datas as $key => $row):?>							
								<form action="delect.php" method="post"><br>
									學號:<input type="varchar" name="delId" value="<?php echo $row['id']; ?>" readonly><br>
									姓名:<label><?php echo $row['name']; ?></label><br>
									系所:<label><?php echo $row['department']; ?></label><br>
									是否領取抽獎卷:<label><?php echo $row['get']; ?></label><br>
									<br>
									<input type="submit" name="delect" value="確定刪除">
								</form>							
								<?php endforeach; ?>										
							<?php else: ?>
							查無資料
						<?php endif; ?>	
					</div>




					<h2>執行結果</h2>
					<div class="well well-sm">
						<?php
						$delId = $_POST['delId'];						
						//將查詢語法當成字串，記錄在$sql變數中
						$sql = "DELETE FROM `member` WHERE `id` like '{$delId}';";
						
						//用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
						$result = mysqli_query($link, $sql);

						if (mysqli_affected_rows($link) > 0)
						{
						echo "刪除成功";
						}
						elseif (mysqli_affected_rows($link) == 0)
						{
						echo "無資料刪除";
						}
						else
						{
						echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($link);
						}
						?>
					</div>
					
				</div>
			</div>
		</div>
		<?php 
		//結束mysql連線
		mysqli_close($link);
		?>
	</body>
</html>
