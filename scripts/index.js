
// var source = new EventSource("user/addUser.php");
// source.onmessage = function(event) {
//   notify(event);
// };

function toggleMenu(x) {
    var menuBox = document.getElementById('menu-box');
    if(menuBox.style.display == "block") { // if is menuBox displayed, hide it
        x.classList.toggle("change");
        menuBox.style.display = "none";
    }
    else { // if is menuBox hidden, display it
      menuBox.style.display = "block";
      x.classList.toggle("change");
    }
}

$(function () {
  $(".trashButton").on('submit', function() {
     deleteBook($bookID);
  })
})

$(document).ready(function() {
  $.getJSON('book/read.php?columnName', function(results) {
    $("#filter").empty();
    $.each(results, function(key, value) {
      $("#filter").append("<option value=\""+value.COLUMN_NAME+"\">"+ value.COLUMN_NAME+"</option>");
    })
  })
})

$(document).on("click", '#profile', function() {
  $("#userData").empty();
  $.getJSON("user/session.php?getFees="+getCookie("userID"), function(results) {
    $("#userData").append("<ul id='datalist'></ul>");
    $.each(results, function(key, value) {
      $("#datalist").append("<li>"+value.fees+"</li>");
    })
    $("#userData").show();
  })
})


$(document).ready( function () {
  $.getJSON('book/read.php?books=1', function(results) {
    mainPage(results); 
  });
})

function mainPage(results) {
  $('.content').empty()
  $.each(results, function(key, value) {
    $('.content').append("<div class='Contentrow"+key+"'></div>");
    $(".Contentrow"+key+"").append( "<div class='box'><img class='contentimg' onclick=\"showBookInfo("+value.bookID+", 'bookinfo')\" src="+value.filePath+"></div>"+
    "<div class='box'><h3>"+value.bookAddition+"</h3></div>"+
    "<div class='box'><h3>"+value.bookName+"</h3></div>"+
      "<div class='box'><h3>"+value.author+"<h3></div>"+
      "<div class='box'><h3>"+value.libraryName+"<h3></div>");
});
}

$('.bookinfoTable').on( 'click', 'tbody td:not(:first-child)', function (e) {
  editor.inline( this );
} );

function needsApproved() {
  $(".content").empty();
  $.getJSON('book/read.php?approve='+getCookie('userID'), function(results) {
    $.each(results, function(key, value) {
      $('.content').append("<div class='Contentrow"+key+"'></div>")
      $('.Contentrow'+key+'').append("<div class='box'><h3>"+value.bookName+"</h3></div>"+
        "<div class='box'><h3>"+value.author+"<h3></div><br>"+
        "<div class='box'><img class='contentimg' src="+value.filePath+"></div>"+
        "<div class='box'><button type='submit' onclick='approveBook("+value.bookID+", 1)' class='approve'><i class='glyphicon glyphicon-ok'></i></button></div>"+
        "<div class='box'><button type='submit' onclick='deleteBook("+value.bookID+")' class='remove'><i class='glyphicon glyphicon-remove'></i></button></div>");
  });
  });
}
$(document).on("change", '#fileToUpload', function() {
  filePreview(this);
});

$(document).on("click", ".profileImage", function() {
  $("#fileToUpload").trigger('click');
})

function filePreview(input) {

  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        // var image = $(".uploadImg");
          $('.uploadImg').attr("src", e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
  }
}



function getUsers() {
  $(".content").empty();
  $.getJSON('user/session.php?getUsers=1', function(results) {
    var fees;
    $.each(results, function(key, value) {
      if(value.fees == null) {
        fees = 0.0;
      }
      $('.content').append("<div class='Contentrow"+key+"'></div>")
      $('.Contentrow'+key+'').append("<div class='box'><h3>"+value.username+"</h3></div>"+
        "<div class='box'><h3>"+value.name+"<h3></div><br>"+
        "<div class='box'>$"+fees+"</div>"+
        "<div class='box><h3>"+value.position+"</h3></div>"+
        "<div class='box'><button type='submit' onclick='deleteUser("+value.userID+")' class='remove'><i class='glyphicon glyphicon-remove'></i></button></div>");
    });
  })
}


function deleteBook (bookID) {
    document.getElementById('bookinfo').style.display = 'none';
    $.getJSON('book/read.php?deleteBook='+bookID, function(results) {
      location.reload();
    });
}

function fillSearchResult(results, filt) {
  $('.autocomplete-items').empty();
  $(".autocomplete").append("<div class='autocomplete-items' id=autocomplete-items>");
    $.each(results, function(key, value) {
      switch (filt) {
        case "bookName":
          $('.autocomplete-items').append("<div><strong>"+value.bookName+"</strong></div>");
          break;
        case "author":
          $('.autocomplete-items').append("<div><strong>"+value.author+"</strong></div>");
          break;
        case "bookAddition":
          $('.autocomplete-items').append("<div><strong>"+value.bookAddition+"</strong></div>");
          break;
        case "libraryName":
          $('.autocomplete-items').append("<div><strong>"+value.libraryName+"</strong></div>");
          break;
        default:
          $('.autocomplete-items').append("<div><strong>"+value.bookName+"</strong></div>");
          break;
      }

  });
  $(".autocomplete").append("</div>");
}

function notify(results) {

$(".notification").empty();
  $(".notification").append("<h3>"+results["Message"]+"</h3>");
    $(".notification").show();
  setTimeout(function() {
    $(".notification").hide();
  }, 3000)
}

$(function() {
  $("#searchForm").on('submit', function(e) {
    e.preventDefault();
      var searchBox = document.getElementById("searchText");
      var filter = document.getElementById("filter");
      var search = searchBox.value;
      var filt = filter.options[filter.selectedIndex].value;
      search = search+"%";
      $.getJSON('book/read.php?search='+search+'&filter='+filt, function(results) {
        if ("Message" in results) {
            notify(results);
        } else {
          mainPage(results);
        }
      })
  })
})

function approveBook(id, approveBit) {
  $.getJSON('book/read.php?approveBook='+id+"&approveBit="+approveBit, 
  function(results) {
      location.reload(true);
    })
}

$(document).ready(function() {
  $.getJSON('library/getLibrary.php?library', function(results) {
    $(".libraryList").empty();
    $.each(results, function(key, value) {
      $(".libraryList").append("<option value='"+value.libraryID+"'>"+ value.libraryName+"</option>");
    })
  })
})



function selectChange() {
  $("#searchResults").empty();
  $("#searchText").val('');
}


$(document).ready(function() {
  var searchBox = document.getElementById("searchText");
  var filter = document.getElementById("filter");
  //on key up search
  $('#searchText').on("keyup", function () {
    var search = searchBox.value;
    var filt = filter.options[filter.selectedIndex].value;
    if (search == "") {
      $.getJSON('book/read.php?books=1', function(results) {
        $('.autocomplete-items').empty();
      })
    } else if (search.slice(-1) ==="%"){
      $.getJSON('book/read.php?search='+search+'&filter='+filt, function(results) {
        if ("Message" in results) {
        } else {
          fillSearchResult(results, filt);
        }
      })
    } else {
        search = search+"%";
        $.getJSON('book/read.php?search='+search+'&filter='+filt, function(results) {
          if ("Message" in results) {
        } else {
          fillSearchResult(results, filt);
        }
      })
    }
  })
})

$(document).ready(function() {
  $.getJSON('book/read.php?columnNames='+getCookie('userID'), 
  function(results) {
    $.each(results, function(key, value) {
      $("#searchSelect").append("<option value='"+value.COLUMN_NAME+"'>"+ value.COLUMN_NAME+"</option>");
    })
    })
    $.getJSON('user/session.php?updateFees=1', function(results) {
    })
})

function logout() {
  $.getJSON('user/session.php?logout='+getCookie('userID'), 
  function() {
      location.reload();
    })
}

$(window).on('load', function() {
  if (getCookie('userID') != "") {
    $('.usrin').show();
    $('.usrout').hide();
    $("#profile").attr('src', getCookie('filePath'));
  
    if (getCookie('position') === 'admin') {
      $('.admin').show();
    }
  }
});

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for (var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}


function  getSearchResults () {
  
    var searchBox = document.getElementById("searchText");
    var filter = document.getElementById("filter");
    var filt = filter.options[filter.selectedIndex].value;
    var search = searchBox.value;
    $.getJSON('book/read.php?search='+search+'&filter='+filt, function(results) {
        mainPage(results);
    })
}

function getUserBooks() {
  if(getCookie('userID') !== "") {
      var userID = getCookie('userID');
    $.getJSON('book/read.php?getUsersBooks='+userID, function(results) {
      if ("Message" in results) {
        notify(results);
    } else {
      $(".content").empty();
        $.each(results, function(key, value) {
          var today = new Date();
          today.setHours(0,0,0,0);
          var date = new Date(value.dueDate);
          var month = date.getMonth() + 1;
          $('.content').append("<div class='Contentrow"+key+"'></div>");
          $(".Contentrow"+key+"").append( "<div class='box'><img class='contentimg' onclick=\"showBookInfo("+value.bookID+", 'bookinfo')\" src="+value.filePath+"></div>"+
          "<div class='box'><h3>"+value.bookName+"</h3></div>"+
            "<div class='box' id='author'><h3>"+value.author+"<h3></div>"+
            "<div class='box' id='date'><h3>"+month+"/"+date.getDate()+"/"+date.getFullYear()+"<h3></div>"+
            "<div class='box' id='libraryName'><h3>"+value.libraryName+"<h3></div>"+
            "<div class='box' id='fees'><h3>$"+value.fees+"<h3></div>");
            if(date < today) {
              var fee = 1.25 * Math.trunc(date / today);
              document.getElementById("date").style.color = "red";
              document.getElementById("fees").style.color = "red";
              
            } else {
              document.getElementById("date").style.color = "green";
            }
          
      });
    }
  })
  
  }
}


$(function () {

  $('#loginForm').on('submit', function(e) {

    e.preventDefault();

    $.ajax({
      type: 'POST',
      url: '/cse201/user/session.php',
      data: $('#loginForm').serialize(),
      success: function ( data ) {
        location.reload();
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log( errorThrown );
      }
    });
  });
});



function loadModal(id, filename) {
  $("#"+id).load(filename);
  showElement(id);
}

$(function () {

  $('#addBookForm').on('submit', function(e) {

    e.preventDefault();

    $.ajax({
      type: 'POST',
      url: 'book/read.php',
      data: $('#addBookForm').serialize(),
      success: function ( data ) {
        if(data !== 'undefined'){
          var json = JSON.parse(data);
      }
          location.reload();
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log( errorThrown );
      }
    });
  });
});



function checkPassword(form) {
    password1 = form.password.value;
    password2 = form.repassword.value;

  if (password1 != password2) {
    notify("Password did not match: please try again")
    return false;
  }else {
    return true;
  }
}





