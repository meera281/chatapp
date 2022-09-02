@extends('agentLayouts.app')
@section('agentcontent')
<div class="content-wrapper">

    <div class="container">
        <div class="col-lg-12">

            <div class="card chat-app">

                    <div id="plist" class="people-list" style="height:589px;">
                        <!-- <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search...">
                        </div> -->
                        <div class="input-group" style="padding-left: 77px;">
                            <div class="input-group-prepend">
                                <h3>Agents</h3>
                            </div>
                        </div>

                        <ul  class="list-unstyled chat-list mt-2 mb-0">
                            <li id="list" class="clearfix">
                                <!-- script -->
                            </li>
                        </ul>
                    </div>

                <script>
                    $(document).ready(function ()       // TO SHOW AGENT LIST
                    {
                        $('#list').html('');
                        $.ajax(
                        {
                            url: "/showagent",
                            method:'get',
                            dataType: 'JSON',
                            success: function(response)
                            {
                                $.each(response.userdetails, function(key,userdetail)
                                {
                                    if( {{session('id')}} == userdetail.id)
                                    {
                                        return;         // skip this iteration
                                    }
                                    $('#list').append(

                                        // "<li class='clearfix'>"+
                                        // "<img src='https://bootdey.com/img/Content/avatar/avatar1.png' alt='avatar'>"+
                                        // "<div class='about'>"+
                                        //     "<div class='name'>"+  "<button id= "+userdetail.id+" type='submit' class='btn btn-light clicked'>"+ userdetail.name +"</button>""</div>"+
                                        //     "<div class='status'> <small>"+ userdetail.email +"</small></div>"+
                                        // "</div>"+
                                        // "</li>"

                                        "<button id= '"+userdetail.id+"' + onclick='hide()' type='submit' class='btn btn-light clicked' style='width: -webkit-fill-available;'>" + 
                                        "<img src='https://bootdey.com/img/Content/avatar/avatar1.png' alt='avatar'>"+
                                            userdetail.name + "<br><small>" + userdetail.email + "</small>"+
                                        "</button>"+
                                        "</div>"    //
                                    );
                                }); 
                            }
                        });
                    });
                </script>

                <div class="chat" id="scroll" style="height:588px; visibility:hidden; overflow-x:hidden; ">
                        
                        <div class="chat-header" style="position: fixed; z-index:1; opacity:100%; width: 812px; background: white;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    <img src='https://bootdey.com/img/Content/avatar/avatar1.png' alt='avatar'>
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="chat-title m-b-0" style="padding-top:11px;"></h6>
                                    </div>
                                </div>
                                <div class="col-lg-2 hidden-sm text-right">
                                    <form action="/deletechat" method="POST">
                                        @csrf
                                        <input type="hidden" name="receiverid" value="" id="receiverchatid">
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn">Delete Chat</button>
                                        <!-- <i class="fas fa-trash"></i> class="btn btn-light mb-3" -->
                                    </form>
                                </div>
                                <div class="col-lg-2 hidden-sm text-right">
                                    <form method="POST" action="/backupchat">
                                        @csrf
                                        <input type="hidden" id="backup" vlaue="" name="backupid">
                                        <button type="submit" class="btn" id="backup">Backup Chat</button>
                                    </form>
                                </div>
                    
                                <div class="col-lg-2 hidden-sm text-right">
                                    <form method="POST" action="/restorechat">
                                        @csrf
                                        <input type="hidden" id="restore" value="" name="restoreid">
                                        <button type="submit" class="btn" id="restore">Restore Chat</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="chat-history" style="margin-top:70px;">
                            <ul id='chat' class="m-b-0">
                                <!-- script -->
                            </ul>
                        </div>

                        <div class="chat-message clearfix">
                            <!-- <form action="/submitchatdata" method="post"> -->
                                <div class="input-group mb-0" style="position:fixed; bottom:30px; right:103px; max-width:814px;">
                                    @csrf
                                    <input type="hidden" name="senderid" value="{{session('id')}}" id="sender" class="form-control">
                                    <input type="hidden" name="receiverid" value="" id="receiver" class="form-control">
                                    <input type="text" name="message" placeholder="Type Message ..." id="message" class="form-control" onkeyup="if(this.value.length > 0) document.getElementById('send').disabled = false; else document.getElementById('send').disabled = true;">
                                    <!-- <div class="input-group-prepend"> -->
                                        <!-- <span class="input-group-text"> -->
                                            <button type="submit" id="send" class="btn btn-primary" disabled> Send </button>
                                        <!-- </span> -->
                                    <!-- </div> -->
                                </div>
                            <!-- </form> -->
                        </div>

                </div>  <!-- chat -->


                    <script>
                        function hide()
                        {
                            var targetDiv = document.getElementById("scroll");       // to hide chat when the button is not clicked
                            if (targetDiv.style.visibility == "hidden")
                            {
                                targetDiv.style.visibility = "visible";
                            } 
                            else {
                                targetDiv.style.visibility = "visible";
                            }
                        }
                    </script>

                    <script>
                        $("#message").keypress(function(event) {
                            if (event.keyCode === 13) {
                                $("#send").click();
                            }
                        });
                    </script>
              
                        <script>
                            var realConfirm=window.confirm;
                                window.confirm=function(){
                                window.confirm=realConfirm;
                                return true;
                                };
                        </script>
                    <script>
                        $(document).ready(function ()
                        {
                            
                            $(document).on('click','.clicked',function()
                            {
                                var buttonid = this.id;
                                $("#receiver").val(buttonid);    // here we assign a value for #receiver
                                $("#receiverchatid").val(buttonid);     // for delete chat
                                $("#backup").val(buttonid);             // for backup chat
                                $("#restore").val(buttonid);            // for restore chat
                                fetchChat(buttonid);
                        
                                // const refresh = setInterval(function()         // REFRESH THE CHAT
                                // {
                                // // stopLoading();
                                // fetchChat(buttonid);
                                // }, 5000);

                                // function stopLoading()
                                // {
                                //     clearInterval(refresh);
                                // }

                                const refresh = setInterval(function(){

                                    $(document).on('click','.clicked',function(){
                                        
                                        stopLoading();

                                    });

                                    fetchChat(buttonid);

                                    }, 7000);

                                function stopLoading(){
                                    clearInterval(refresh);
                                }

                            });


                            $(document).on('click','#send',function()
                            {
                                var id = $("#receiver").val();      // its scope is in throughout the func
                                let data = {                        // its scope is only in this func
                                    'senderid': $("#sender").val(),
                                    'receiverid': $("#receiver").val(),
                                    'message': $("#message").val()
                                }
                                saveChat(data);
                                // alert(id);
                                fetchChat(id);            //to display chat the moment send button is clicked
                                fetchChat(id); 
                            });


                            function saveChat(data)
                            {
                                $.ajaxSetup(
                                {
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax(         // here api is cAlled
                                {
                                    url: "/submitchatdata",
                                    method:'POST',
                                    data: data,
                                    dataType: 'JSON',
                                    success: function(response)
                                    {
                                        console.log(response.message);
                                    },
                                });
                                $("#message").val('');         // here we give blank value to message
                            }

                            
                            function fetchChat(id)       //
                            {
                                $('#chat').html('');        // Empty the loaded html content of #chat
                                $.ajax(                 // there are only predefined things (it is used to load data)
                                {
                                    url: "/getchatdata/"+id ,      //
                                    method:'get',
                                    dataType: 'JSON',
                                    success: function(response) // if data received successfully from contt. then we'll access this func
                                    {
                                        $('.chat-title').empty().append(response.name);
                                        // alert("Chat Fetched Successfully"); 
                                        $.each(response.chatmessage, function(key,chat)
                                        {
                                            if(chat.type == 'outgoing')
                                            {
                                                $('#chat').append(
                                                "<li class='clearfix'>"+
                                                "<div class='message-data text-right'>"+
                                                "<span class='message-data-time'>"+ chat.time +"</span>"+
                                                // "<img src='https://bootdey.com/img/Content/avatar/avatar7.png' alt='avatar'>"+
                                                "</div>"+
                                                "<div class='message other-message float-right'>"+ chat.message +"</div>"+
                                                "</li>"
                                                );
                                            }
                                            if(chat.type == 'incoming')
                                            {
                                                $('#chat').append(
                                                "<li class='clearfix'>"+
                                                "<div class='message-data'>"+
                                                "<span class='message-data-time'>"+ chat.time +"</span>"+
                                                "</div>"+
                                                "<div class='message my-message'>"+ chat.message +"</div>"+
                                                "</li>"
                                                );
                                            }
                                        }); 

                                        var messageBody = document.querySelector('#scroll');                     // for scroll down
                                        messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;

                                        // $('#chat').append("Chat Ended");  
                                    }
                                });
                            }
                        
                        });
                    </script>

                    <!-- <script> var messageBody = document.querySelector('#chat');
                            messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
                    </script> -->
                    

            </div>
        <div>       <!-- col-lg-12 -->
    </div>    <!-- container-fluid -->

</div>       <!-- Content-wrapper -->
@endsection







