
             

function showElement(i) {
    document.getElementById(i).style.display='block';
}

function showBookInfo(id,i) {
    $('.bookinfoTable').empty();
    var flag;
    $(".trashButton").remove();
    $("#checkOutBook").remove();
    $("#renewBook").remove();
    $.getJSON("book/read.php?bookID="+id, function(results) {
        if($(window).width() > 760) {
            tableHeaderTop(results);
        } else {
            tableHeaderLeft(results);
        }
    });
    document.getElementById(i).style.display='block';  

}


function tableHeaderLeft(results) {
    $.each(results, function(key, value) {
        username = (value.username === null) ? "none" : value.username;
        var name = "";
        if(value.userID !== null ) {
            name = "Renew Book";
        } else {
            name = "Check Out Book";
        }
        $('.bookinfoTable').append(
        "<tr><th id='bookName'>Book Name</th>"+ '<td><span class="row_data" col_name="bookName" edit_type="click">'+value.bookName+'</span></td></tr>'+
        "<tr><th id='author'>Author</th>" + '<td><span class="row_data" col_name="author" edit_type="click">'+value.author+'</span></td></tr>'+
        "<tr><th id='filePath'>Book Cover</th>" + '<td><span class="row_data" col_name="filePath" edit_type="click"><img class="bookinfoimg" src='+value.filePath+'></span></td></tr>'+
        "<tr><th id='bookAddition'>Addition</th>" + '<td><span class="row_data" col_name="bookAddition" edit_type="click">'+value.bookAddition+'</span></td></tr>'+
        "<tr><th id='libraryName'>Library</th>" + '<td><span class="row_data" col_name="libraryName" edit_type="click">'+value.libraryName+'</span></td></tr>'+
        "<tr><th id='libraryAddress'>Library Address</th>" + '<td><span class="row_data" col_name="libraryAddress" edit_type="click">'+value.libraryAddress+'</span></td></tr>'+
        "<tr><th id='username'>Checked Out By</th>" + '<td><span class="row_data" col_name="username" edit_type="click">'+username+'</span></td></tr>');
       
           $("#bookinfoModal").append("<button id='checkOutBook' class='checkOutBook usrin' type='button'>"+name+"</button>");
           $("#bookinfoModal").append("<button id='trashButton' class='trashButton admin' type='button' onclick='deleteBook("+value.bookID+")'></button>");
           $("#trashButton").append("<i class='glyphicon glyphicon-trash'></i>");
           
        
     });
     if (getCookie('userID') != "") {
        document.getElementById("checkOutBook").style.display="block";
    } 
    if(getCookie("position") != "admin") {
        document.getElementById("trashButton").style.display='none';
    } else {
        document.getElementById("trashButton").style.display="block";
    }
}

function tableHeaderTop(results) {
    $.each(results, function(key, value) {
        $('.bookinfoTable').append("<tr id="+value.bookID+">"+
        "<th id='bookName'>Book Name</th>"+
        "<th id='author'>Author</th>"+
        "<th id='filePath'>Book Cover</th>"+
        "<th id='bookAddition'>Addition</th>"+
        "<th id='libraryName'>Library</th>"+
        "<th id='libraryAddress'>Library Address</th>"+
        "<th id='username'>Checked Out By</th>"+         
        "</tr>");
        username = (value.username === null) ? "none" : value.username;
         $(".bookinfoTable").append("<tr row_id="+value.bookID+">"+
            '<td><span class="row_data" col_name="bookName" edit_type="click">'+value.bookName+'</span></td>'+
            '<td><span class="row_data" col_name="author" edit_type="click">'+value.author+'</span></td>'+
            '<td><span class="row_data" col_name="filePath" edit_type="click"><img class="bookinfoimg" src='+value.filePath+'></span></td>'+
            '<td><span class="row_data" col_name="bookAddition" edit_type="click">'+value.bookAddition+'</span></td>'+
            '<td><span class="row_data" col_name="libraryName" edit_type="click">'+value.libraryName+'</span></td>'+
            '<td><span class="row_data" col_name="libraryAddress" edit_type="click">'+value.libraryAddress+'</span></td>'+
            '<td><span class="row_data" col_name="username" edit_type="click">'+username+'</span></td>'+
           "</tr>");
           var name = "";
           if(value.userID !== null ) {
               name = "Renew Book";
           } else {
               name = "Check Out Book";
           }
           $("#bookinfoModal").append("<button id='checkOutBook' class='checkOutBook usrin' type='button'>"+name+"</button>");
           $("#bookinfoModal").append("<button id='trashButton' class='trashButton admin' type='button' onclick='deleteBook("+value.bookID+")'></button>");
           $("#trashButton").append("<i class='glyphicon glyphicon-trash'></i>");
           
        
     });
     if (getCookie('userID') != "") {
        document.getElementById("checkOutBook").style.display="block";
    } 
    if(getCookie("position") != "admin") {
        document.getElementById("trashButton").style.display='none';
    } else {
        document.getElementById("trashButton").style.display="block";
    }
}

    


$(document).on("click", '#checkOutBook', function() {
    var table = document.getElementById("bookinfoTable"); 
    var row = table.rows[0];
    var bookID = row.id;
    $.getJSON("book/read.php?checkOutBook="+bookID, function() {
      location.reload();
    })
  })


$(document).on('focusout', '.row_data', function(event) 
	{
		event.preventDefault();

		if($(this).attr('edit_type') == 'button')
		{
			return false; 
		}

		var row_id = $(this).closest('tr').attr('row_id'); 
		
		var row_div = $(this)				
		.removeClass('bg-warning') //add bg css
		.css('padding','')

		var col_name = row_div.attr('col_name'); 
        var tmp = row_div.html(); 
        var newtext = tmp.replace(/&nbsp;/g,' ');
        var col_val = newtext.trim();

        $.getJSON("book/read.php?updateBook="+row_id+"&tableColumnName="+col_name+"&tableColumnValue="+col_val, function(results) {
            location.reload();
        });		
	})

$(document).on('click', '.row_data', function(event) 
{
    if(getCookie('position') == 'admin'){
        event.preventDefault(); 

        if($(this).attr('edit_type') == 'button')
        {
            return false; 
        }
    
        //make div editable
        $(this).closest('div').attr('contenteditable', 'true');
        //add bg css
        $(this).addClass('bg-warning').css('padding','5px');

        $(this).focus();
    }
})

// Get the modal


// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    var modal = document.getElementById('addUserID');
    var loginmodal = document.getElementById('loginID');
    var bookinfo = document.getElementById('bookinfo');
    var approve = document.getElementById('approveModal');
    var addbook = document.getElementById('addBookModal');


    if (event.target == modal) {
        modal.style.display = "none";
    }else if (event.target == loginmodal) {
        loginmodal.style.display = "none";
    }else if (event.target == bookinfo) {
        bookinfo.style.display = "none";
    } else if (event.target == approve) {
        approve.style.display = "none";
    }else if(event.target == addbook) {
        addbook.style.display = "none";
    }
}



window.onkeydown = function(e) {
    var key = e.keyCode ? e.keyCode : e.which;
    var modal = document.getElementById('addUserID');
    var loginmodal = document.getElementById('loginID');
    var bookinfo = document.getElementById('bookinfo');
    var approve = document.getElementById('approveModal');
    var addBook = document.getElementById('addBookModal');


    if(key == 27) {
        modal.style.display = "none";
        loginmodal.style.display = "none";
        bookinfo.style.display = "none";
        addBook.style.display = "none";
    }
}