<?php 
echo "<footer id='car-app-footer'><img src='images/sus-polar.jpg' class='circle' alt='hmmm'><p>Site Designed By Bears of Saturn, we are not aliens! &copy; 2025</p></footer>";
?>

<style>
#car-app-footer {
  display: flex;
  align-items: center;  
  justify-content: flex-start; 
  margin-bottom: 20px;
  padding: 05px;  
  width: 100%; 
}

#car-app-footer .circle {
  width: 80px;       
  height: 80px;
  border-radius: 50%;
  object-fit: cover; 
  margin-right: 15px; 
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

#car-app-footer p {
  margin: 0; 
  flex-grow: 1;  
  word-wrap: break-word; 
  padding-left: 10px;
}
</style>
