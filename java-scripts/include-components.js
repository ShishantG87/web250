


fetch('components/header.html')
    .then(response => response.text())  
    .then(data => {
        document.getElementsByTagName('header')[0].innerHTML = data;
    })
   


    
fetch('components/footer.html')
.then(response => response.text())  
.then(data => {
    document.getElementsByTagName('footer')[0].innerHTML = data;
})
