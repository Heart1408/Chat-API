<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="join_conversation" method="post">
        @csrf
        <label for="conversation">Join conversation</label>
        <input name="conversation_id" type="text">
        <button type="submit">Join</button>
    </form>

    <form action="add_to_conversation" method="post">
        @csrf
        <input type="hidden" name="conversation_id" value="2">
        <button type="submit">Add user</button>
    </form>

    <form action="remove_from_conversation" method="post">
        @csrf
        <input type="hidden" name="conversation_id" value="2">
        <button type="submit">Remove user</button>
    </form>

    <form action="user/search_by_name" method="post">
        @csrf
        <label for="name"></label>
        <input type="text" name="name">
        <button type="submit">Search</button>
    </form>

    <form action="create_conversation" method="post">
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name">
        <select multiple size="6" name="user_ids[]">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select>

        <button type="submit">Create Conversation</button>
    </form>

    <form action="user/upload_user_avatar" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="avatar">
        <button type="submit">Upload User Avatar</button>
    </form>

    <form action="chat/upload_conversation_avatar" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="avatar">
        <input type="text" name="conversation_id">
        <button type="submit">Upload Conversation Avatar</button>
    </form>

    <form action="user/change_user_name" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name">
        <button type="submit">Change Name</button>
    </form>

    <form action="chat/get_conversation_data" method="get">
        @csrf
        <input type="text" name="conversation_id">
        <button type="submit">GET data</button>
    </form>
</body>
</html>