@extends('layouts.app')

@section('title')
    Бутики магазина
@endsection

@section('meta-desc', 'Обзор всех бутиков интернет магазина ITSshop')
@section('og-desc', 'Обзор всех бутиков интернет магазина ITSshop')
@section('og-title', 'Все бутики магазина')
@section('url', route('categories'))

@section('content')
    <!-- Page Title-->
    <div class="page-title">
        <div class="container">
            <div class="column">
                <h1>Диалог с "{{ $participant->name }}"</h1>
            </div>
            {{ Breadcrumbs::render('categories') }}
        </div>
    </div>
    <div class="container padding-bottom-3x mb-1">
        <div class="row">
            <div class="col-lg-9">
              <audio id="newmessage">
                    <source src="{{ asset('plucky.mp3') }}"></source>
              </audio>
              <meta name="userId" content="{{ auth()->user()->id }}">
              <meta name="convId" content="{{ $conversation->id }}">
              <meta name="name" content="{{ auth()->user()->name }}">
              <meta name="avatar" content="{{ auth()->user()->avatar }}">
              <div class="info">
                  <a href="/inbox" class="btn btn-primary btn-sm">К списку сообщений</a>
              </div>
              @if($messages)
              <div id="pagination">
                  {{ $messages->links('pagination.ajax') }}
              </div>
              @endif
              <ul class="messages-list" style="height: 700px; overflow-y: auto" v-chat-scroll>
                @foreach($messages as $message)
                <li>
                    <div class="row margin-left-none margin-right-none">
                        <div class="col-md-2 padding-right-none">
                            <div class="avatar-user text-center">
                                    <img src="{{ $message->sender->avatar }}" alt="$message->sender->name">
                            </div>
                        </div>

                        <div class="col-md-10 padding-left-none">
                            <div class="user-name">
                                <span>{{ $message->sender->name }}
                                    @if(Helper::getOnlineUser($message->sender->id))
                                    <i data-toggle="tooltip" title="Онлайн" class="material-icons online">fiber_manual_record</i>
                                    @else 
                                    <i data-toggle="tooltip" title="Оффлайн" class="material-icons offline">fiber_manual_record</i>
                                    @endif
                                    <span class="date float-right">{{ $message->created_at->diffForHumans() }}</span></span>
                            </div>
                            <div class="message">
                                {{ $message->body }}
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
                <message v-for="value,index in chat.message" 
                    :key=value.index 
                    :user=chat.user[index]
                    :message="chat.message[index]"
                    :time="chat.time[index]"
                    :seen="chat.seen[index]"
                >
                </message>
              </ul>
              <div class="send-message margin-bottom-1x">
                  <div class="panel-user">
                      <div class="pb-2 m-size-u float-left">
                          <div><strong>{{ $participant->name }}</strong></div>
                          <div><span class="text-muted" v-text="typing"></span></div>
                          <div>
                            @if(Helper::getOnlineUser($participant->id))
                                <span style="color: #0b0">Онлайн</span>
                            @else
                                <span class="text-muted">Оффлайн</span>
                            @endif
                          </div>
                      </div>
                  </div>
                  <div class="calc-text pb-2 float-right">
                      <span id="maxlengthmess">0</span>
                      <span>/ 4000</span>
                  </div>
                  <div class="form-group">
                    <textarea maxlength="4000" cols="80" rows="3" class="message-input form-control" v-model='message' v-on:click="seenMessage" onkeyup="calc_input_text(this)"></textarea>
                  </div>
                  <div class="form-group">
                      <button type="button" class="btn btn-lg btn-primary" v-on:click="send">Отправить сообщение</button>
                  </div>
              </div>
              @if($messages)
              <div id="pagination">
                  {{ $messages->links('pagination.ajax') }}
              </div>
              @endif
            </div>
            <div class="col-lg-3">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti, iure totam ex laborum quidem vel nemo eveniet dolores natus id exercitationem veritatis maiores labore eum nam ab possimus, dolorum architecto!
            </div>
        </div>
    </div>
@endsection