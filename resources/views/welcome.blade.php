<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DDST</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    </head>
    <body>
        <div class="class">
            <h1 id="title">Child Developmental Screening Tool</h1>
            <div class="content">
                <div class="section">
                    <h2>What is Child Developmental Screening Tool?</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pharetra ligula a enim fringilla, nec commodo dolor tincidunt. Suspendisse convallis dolor eu risus laoreet suscipit. Maecenas scelerisque ac magna non tempor. Vestibulum at dolor sem. Etiam aliquet tincidunt scelerisque. Aliquam turpis arcu, ornare id sem in, ornare pharetra tellus. Proin finibus, augue at tincidunt fringilla, eros diam suscipit urna, ut pretium nunc augue vitae leo. Mauris ante erat, pellentesque eu elit non, luctus porttitor elit. Nulla vel finibus dui.</p>
                    <button class="submit-btn" id="cta-button">Take Test Now!</button>
                </div>
                <div class="section">
                    <h2>Important Notice</h2>
                    <p>Nam elementum tincidunt ultricies. Morbi vitae massa sed purus placerat sagittis non eu nibh. Fusce condimentum egestas aliquet. In sit amet lobortis orci, pharetra viverra purus. Pellentesque eu sollicitudin nunc. Morbi rutrum volutpat metus, rhoncus facilisis nisl. Maecenas ultricies dictum diam, sed vulputate eros aliquet quis. Curabitur non suscipit lorem. Praesent id ornare mi, eu sagittis lorem. Integer non sapien ut orci vestibulum tristique ut ut urna. Nunc tempor, orci in vehicula vulputate, leo sapien sagittis magna, semper ullamcorper ligula est ut erat.</p>
                </div>
            </div>
        </div>

        <footer>
            <p>&copy; 2024 - Kevin - Alpha Build</p>
        </footer>

        
    </body>
    <script>
        document.getElementById('cta-button').addEventListener('click', function(){
            window.location = '{{ url('form') }}';
        });
    </script>
</html>
