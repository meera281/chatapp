@extends('agentLayouts.app')
@section('agentcontent')
<div class="content-wrapper">

    <div class="container-fluid">
        <div class="row">


            <div class="col-lg-3">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-warning">
                        <tr>
                            <td>Agents</td>
                        </tr>
                    </thead>
                    <tbody id="list">
                        <!-- script -->
                    </tbody>
                </table>
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
                                    "<tr>"+
                                        "<td><button id= '"+userdetail.id+"' + type='submit' class='btn btn-dark clicked'>" + userdetail.name + "<br><small>" + userdetail.email + "</small></button></td>"+
                                    "</tr>"
                                );
                            }); 
                        }
                    });
                });
            </script>


            <div class="col-lg-9 card card-dark direct-chat direct-chat-primary">

                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <div class="card-tools">
                        <!-- <span data-toggle="tooltip" title="3 New Messages" class="badge badge-light">3</span> -->
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                        <!-- <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                        <i class="fas fa-comments"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button> -->
                    </div>
                </div>

                <div class="card-body">
                  <div id='chat' class='direct-chat-messages' style='height : 500px;'>
                     <!-- script -->
                  </div>
                </div>

                <div class="card-footer">
                    <!-- <form action="/submitchatdata" method="post"> -->
                        <div class="input-group">
                            @csrf
                            <input type="hidden" name="senderid" value="{{session('id')}}" id="sender" class="form-control">
                            <input type="hidden" name="receiverid" value="" id="receiver" class="form-control">
                            <input type="text" name="message" placeholder="Type Message ..." id="message" class="form-control" onkeyup="if(this.value.length > 0) document.getElementById('send').disabled = false; else document.getElementById('send').disabled = true;">
                            <span class="input-group-append">
                            <button type="submit" id="send" class="btn btn-primary" disabled>Send</button>
                            
                            </span>
                        </div>
                    <!-- </form> -->
                </div>

            </div>  <!-- col-lg-9 -->


            <script> var messageBody = document.querySelector('#chat');
                        messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
            </script>


                <script>
                    $(document).ready(function ()
                    {
                        
                        $(document).on('click','.clicked',function()
                        {
                            let buttonid = this.id;
                            $("#receiver").val(buttonid);       // here we assign a value for #receiver
                            fetchChat(buttonid);
                    
                            
                            const refresh = setInterval(function()         // REFRESH THE CHAT
                            {
                            // stopLoading();
                            fetchChat(buttonid);
                            }, 5000);

                            function stopLoading()
                            {
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
                            fetchChat(id);       //to display chat the moment send button is clicked
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
                                success: function(response) // if data received successfully from controller then we'll access this func
                                {
                                    $('.card-title').empty().append(response.name);
                                    // alert("Chat Fetched Successfully"); 
                                    $.each(response.chatmessage, function(key,chat)
                                    {
                                        if(chat.type == 'outgoing')
                                        {
                                            $('#chat').append(
                                            "<div class='direct-chat-msg'>"+
                                            "<div class='direct-chat-infos clearfix'>"+
                                            "<span class='direct-chat-name float-right'>"+ chat.creator + "</span>"+
                                            "<span class='direct-chat-timestamp float-left'>"+ chat.created_at + "</span></div>"+
                                            "<div class='direct-chat-text'>"+ chat.message + "</div></div>"
                                            );
                                        }
                                        if(chat.type == 'incoming')
                                        {
                                            $('#chat').append(
                                            "<div class='direct-chat-msg right'>"+
                                            "<div class='direct-chat-infos clearfix'>"+
                                            "<span class='direct-chat-name float-left'>"+ chat.creator + "</span>"+
                                            "<span class='direct-chat-timestamp float-right'>"+ chat.created_at + "</span></div>"+
                                            "<div class='direct-chat-text'>"+ chat.message + "</div></div>"
                                            );
                                        }
                                    }); 

                                    var messageBody = document.querySelector('#chat');      // for scroll down
                                    messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;

                                    // $('#chat').append("Chat Ended");  
                                }
                            });
                        }

                    
                    });
                </script>
                
                
        </div>      <!-- row -->

    </div>    <!-- container-fluid -->

</div>       <!-- Content-wrapper -->
@endsection







