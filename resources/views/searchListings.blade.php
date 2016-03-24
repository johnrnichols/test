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
        <div class="title">Listing Search Page</div>
            <table id="table" class="display compact" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>MlsNumber</th>
                        <th>ListPrice</th>
                        <th>ListingURL</th>
                        <th>Description</th>
                        <th>Bedrooms</th>
                        <th>Bathrooms</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> 15476</td>
                        <td> $160000</td>
                    </tr>
                </tbody>
            </table> 
        <script>

        $(document).ready(function(){

            jQuery.support.cors = true;

            $.ajax({
                type: "GET",
                url: 'http://localhost/json_listings/',
                data: "{}",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function (data) {
                    
                    var trHTML = '';
                            
                    $.each(data.Countries, function (item, i) {
                        
                        trHTML += '<tr><td>' + data.MlsNumber[i] +
                                  '</td><td>' + data.ListPrice[i] +
                                  '</td><td>' + data.ListingURL[i] +
                                  '</td><td>' + data.Description[i] +
                                  '</td><td>' + data.Bedrooms[i] +
                                  '</td><td>' + data.Bathrooms[i] +
                                  '</td><td>' + data.Type[i] +
                                  '</td><td>' + data.Category[i] +
                                  '</td><td>' + data.Status[i] +
                                  '</td></tr>';
                    });
                
                $('#table').append(trHTML);
                
                },
                
                error: function (msg) {
                    
                    alert(msg.responseText);
                }
            });
        })

        </script>
            </div>
        </div>
    </body>
</html>