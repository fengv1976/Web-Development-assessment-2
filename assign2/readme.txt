Name: Victor Feng
ID: 17983916

File List:

admin.html
admin.js
admin.php
assign.php
booking.html
booking.js
booking.php
index.html
style.css

Found here (http://cqx1835.cmslamp14.aut.ac.nz/assign2/)

Instructions:

    index.html
    ----------
    Use to navigate between the admin.html and booking.html.

    booking.html
    ------------
    Fill all in all input in the page, with all input fields with the "*" character being required 
    for a booking request to be made. If any text field is entered incorrectly 
    (eg. name contains a number, phone contain letters, require input left empty, etc.) an appropriate 
    message relevant to the error. If a booking request was successfully made, a confirmation message 
    is shown with the booking number displayed with other information in the request.

    admin.html
    ----------
    This contains two sections:
	    -Show booking request
	        This has a text field in which if left when the search booking button is clicked on, all 
            bookings request with the status of unassigned and two hours from the current system time
            are shown in a table with other details. if there is input in the text field, it will first
            check if the user input is numbers only and if it exsit and if false, display an error 
            message. but if a booking number is found, it will show the booking entry.
	    -Update Status
            If the booking request is found and the status is unassigned, the update status button will
            have booking request be updated to now show assigned with a confirmation message shown 
            below. If an error occurs like a booking request already assigned, no input in the text 
            field will have the appropriate message be shown.