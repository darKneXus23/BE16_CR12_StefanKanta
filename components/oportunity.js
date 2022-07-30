
const all = new XMLHttpRequest();
all.open("get", 'api/displayAll.php');
all.onload = function(){
                const data = JSON.parse(all.responseText);
                content = document.getElementById("content");
                content.innerHTML = "";
                for (i=0; i<data.length; i++) {
                    if (data[i]["reduction"] == 1) {
                        content.innerHTML += "<div class='col'><div class='card border-0'>"
                            +"<img src='image/" + data[i]["image"] + "' class='card-img-top rounded-0'>"
                            +"<div class='card-body'><h6 class='card-title'>" + data[i]["title"] + "</h6>"
                            +"<p class='card-text'>" + data[i]["city"] + "</p><p class='card-text'>" + data[i]["title"] + "</p>"
                            +"<p class='card-text'>" + data[i]["price"] + "</p></div></div></div>";
                    }
                }
            };
all.send();