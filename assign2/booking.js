function createRequest() {
    var xhr = false;  
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xhr;
} 

var xhr = createRequest();

function getData(dataSource, divID, cname, phone, unumber,snumber,stname,sbname,dsbname,date,time)  
{
    if(xhr) {
	    var place = document.getElementById(divID);
	    var requestbody ="name="+encodeURIComponent(cname)+
        "&phone="+encodeURIComponent(phone)+
        "&unumber="+encodeURIComponent(unumber)+
        "&snumber="+encodeURIComponent(snumber)+
        "&stname="+encodeURIComponent(stname)+
        "&sbname="+encodeURIComponent(sbname)+
        "&dsbname="+encodeURIComponent(dsbname)+
        "&date="+encodeURIComponent(date)+
        "&time="+encodeURIComponent(time); 
	    xhr.open("POST", dataSource, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	    xhr.onreadystatechange = function() {
		    alert(xhr.readyState);
			if (xhr.readyState == 4 && xhr.status == 200) {
				place.innerHTML = xhr.responseText; 
		    } 
	    } 
	    xhr.send(requestbody);
	} 
} 
