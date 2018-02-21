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
                <h1>Сообщения</h1>
            </div>
            {{ Breadcrumbs::render('categories') }}
        </div>
    </div>
    <div class="container padding-bottom-3x mb-1">
        <div class="row">
          <div class="col-lg-12">
              <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item"><a class="nav-link active" href="#right" data-toggle="tab" role="tab">Все</a></li>
                  <li class="nav-item"><a class="nav-link" href="#top" data-toggle="tab" role="tab">Непрочитанные</a></li>
                  <li class="notifies"><a data-toggle="tooltip" title="Уведомления отключены" href="#"><i class="icon-bell text-warning"></i></a></li>
              </ul>

              <div class="tab-content padding-top-none padding-left-none padding-right-none padding-bottom-none">
                  <div class="tab-pane transition fade right show active" id="right" role="tabpanel">
                      <div class="table-responsive">
                          <table class="table list-mes margin-bottom-none">
                            <thead>
                              <tr>
                                <th>Получатель</th>
                                <th></th>
                                <th><a href="#">Обновлено</a></th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($conversations as $key => $confs)
                              
                              <tr onclick="window.location.href = '{{ route('chatconv', $confs->last_message->conversation_id) }}'">
                                  <td><img class="user-avatar" src="{{ $recipient[$key]->avatar }}" alt="{{ $confs->last_message->sender->name }}"> <span class="name">{{ $recipient[$key]->name }}
                                    @if(Helper::getOnlineUser($recipient[$key]->id))
                                    <i data-toggle="tooltip" title="Онлайн" class="material-icons online">fiber_manual_record</i>
                                    @else
                                    <i data-toggle="tooltip" title="Оффлайн" class="material-icons offline">fiber_manual_record</i>
                                    @endif
                                  </span></td>
                                  <td>{{ $confs->last_message->body }}</td>
                                  <td>{{ $confs->last_message->updated_at->diffForHumans() }}</td>
                              </tr>
                              @endforeach
                              <!-- <tr>
                                  <td><img class="user-avatar" src="{{ (Auth::user()->avatar !== null) ? Auth::user()->avatar : asset('img/account/user-ava-sm.jpg') }}" alt=""> <span class="name">Дмитрий Грамчук <i data-toggle="tooltip" title="Онлайн" class="material-icons online">fiber_manual_record</i></span></td>
                                  <td><span class="unread-s bg-faded"><img class="user-avatar-sm" src="{{ (Auth::user()->avatar !== null) ? Auth::user()->avatar : asset('img/account/user-ava-sm.jpg') }}" alt=""> Я хотел бы заказать у вас эту штуку</span></td>
                                  <td>25 фев, 11:07</td>
                              </tr>
                              <tr>
                                  <td><img class="user-avatar" src="{{ (Auth::user()->avatar !== null) ? Auth::user()->avatar : asset('img/account/user-ava-sm.jpg') }}" alt=""> <span class="name">Дмитрий Грамчук <i data-toggle="tooltip" title="Онлайн" class="material-icons online">fiber_manual_record</i></span></td>
                                  <td>Я хотел бы заказать у вас эту штуку</td>
                                  <td>25 фев, 11:07</td>
                              </tr> -->
                            </tbody>
                          </table>
                      </div>
                  </div>
                  <div class="tab-pane transition fade top" id="top" role="tabpanel">
                      <div class="table-responsive">
                          <table class="table unread margin-bottom-none">
                            <thead>
                              <tr>
                                <th>Получатель</th>
                                <th></th>
                                <th><a href="#">Обновлено</a></th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img class="user-avatar" src="{{ (Auth::user()->avatar !== null) ? Auth::user()->avatar : asset('img/account/user-ava-sm.jpg') }}" alt=""> <span class="name">Дмитрий Грамчук <i data-toggle="tooltip" title="Онлайн" class="material-icons offline">fiber_manual_record</i></span></td>
                                    <td>Почему не отвечаете ..</td>
                                    <td>25 фев, 11:07</td>
                                </tr>
                                <tr>
                                    <td><img class="user-avatar" src="{{ (Auth::user()->avatar !== null) ? Auth::user()->avatar : asset('img/account/user-ava-sm.jpg') }}" alt=""> <span class="name">Дмитрий Грамчук <i data-toggle="tooltip" title="Онлайн" class="material-icons offline">fiber_manual_record</i></span></td>
                                    <td>Почему не отвечаете ..</td>
                                    <td>25 фев, 11:07</td>
                                </tr>
                            </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              @if($conversations)
                <div id="pagination">
                    {{ $conversations->links('pagination.ajax') }}
                </div>
              @endif
          </div>
        </div>
    </div>
@endsection