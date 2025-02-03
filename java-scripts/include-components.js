


fetch('components/header.html')
    .then(response => response.text())  
    .then(data => {
       
        document.getElementById('header').innerHTML = data;
    })
    .catch(error => {
        
        document.getElementById('header').innerHTML = "Cant load header.";
        console.error("Error loading HTML file:", error);
    });


    
fetch('components/footer.html')
.then(response => response.text())  
.then(data => {
   
    document.getElementById('footer').innerHTML = data;
})
.catch(error => {
    
    document.getElementById('footer').innerHTML = "Cant load footer.";
    console.error("Error loading HTML file:", error);
});
