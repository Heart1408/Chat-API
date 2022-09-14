<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Chat Page</title>
</head>
<body>
    <section id="conversations">
        
    </section>
    @yield('content')

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        getConversation();
        function getConversation() {
            $.ajax({
                url: 'chat/get_conversations',
                type: 'GET',
                data: {

                }
            }).done(function (data) {
                var row = '';
                
                $.each(data, function (key, value) {
                    $.each(value, function (k, v) {
                        console.log(v);
                        row += '<a id="conversationId" value="'+ v.chat_id +'">' + v.avatar + '</a>';
                    })
                })

                $('#conversations').html(row);
            })
        }
    </script>
</body>
</html>