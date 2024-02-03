
const searchBox = document.querySelector(".search input");
const searchBtn = document.querySelector(".search button");
const weatherIcon = document.querySelector(".weather-icon");

const date = document.querySelector(".date")

async function checkWeather(city){
                const apiKey ="9cf439b778e27ab987df28a6bfc130a0";
                const apiUrl =`http://localhost/php2/web.php?q=${city}`;
                const response = await fetch(apiUrl + `&appid=${apiKey}`);

                if(response.status == 404){
                    document.querySelector(".error").style.display = "block";
                    document.querySelector(".weather").style.display ="none";

                }else{
                  var data = await response.json();



                  console.log(data);

                  const currentDate = new Date();
                  date.textContent = currentDate.toDateString();



                  document.querySelector(".city").innerHTML = data[0].city;
                  document.querySelector(".temp").innerHTML = Math.round(data[0].temperature) + "°C";
                  document.querySelector(".humidity").innerHTML = data[0].humidity + "%";
                  document.querySelector(".wind").innerHTML = data[0].wind + "km/hr";
                  document.querySelector(".description").innerHTML = data[0].weather_description;
                  document.querySelector(".weather-icon").src = `https://openweathermap.org/img/wn/${data[0].cloud}@4x.png`;


                  for (let i in data)
       {
        
       document.querySelectorAll(".past-day-card")[i].innerHTML = 
       `
       <p>${data[i].timedate}</p>
       <img src =  "https://openweathermap.org/img/wn/${data[i].cloud}@4x.png" >
       <p>Description: <span>${data[i].weather_description}</span><p>
       <p>Temperature: ${data[i].temperature}&degC</p>
       <p>Humidity: ${data[i].humidity} %</p>
       <p>Windspeed: ${data[i].wind} Km/hr</p>`
      }
      }
                  
                }  
            

            searchBtn.addEventListener("click",()=>{
                checkWeather(searchBox.value);
                searchBox.value =""
            })

             

checkWeather("mysuru");
