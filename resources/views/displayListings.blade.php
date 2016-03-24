<?php
    $listings = json_decode($jsonListings);
    //$addresses = json_decode($jsonAddresses);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Listings</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Times';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: top;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 32px;
            }
        </style>
    </head>
    <body>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <div class="container">
            <div class="content">
                <div class="title">Listing Search Page</div>
                <div class="container-fluid">
                    <div class="panel-heading">
                        </div>
                            <div id="colvis"></div><br>
<table id="personDataTable">
    <tr>
        <th>MlsNumber</th>
        <th>ListPrice</th>
        <th>ListingURL</th>
    </tr>
    
</table>
                            </div>
                        <script type="text/javascript">
                            
$.ajax({
    url: 'localhost/json_listings',
    type: "GET",
    dataType: "json",
    data: {},
    success: function(data, textStatus, jqXHR) {
        // since we are using jQuery, you don't need to parse response
        drawTable(data);
    }
});

function drawTable(data) {
    for (var i = 0; i < data.length; i++) {
        drawRow(data[i]);
    }
}

function drawRow(rowData) {
    var row = $("<tr />")
    $("#personDataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
    row.append($("<td>" + rowData.MlsNumber + "</td>"));
    row.append($("<td>" + rowData.ListPrice + "</td>"));
    row.append($("<td>" + rowData.ListingURL + "</td>"));
}

                        </script>
            </div>
        </div>
    </body>
</html>
