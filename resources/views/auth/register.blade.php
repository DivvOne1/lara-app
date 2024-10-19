@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Регистрация</div>

                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5>Выберите тип регистрации:</h5>
                            <a href="{{ route('client.register') }}" class="btn btn-primary mr-2">Зарегистрироваться как клиент</a>
                            <a href="{{ route('courier.register') }}" class="btn btn-primary">Зарегистрироваться как курьер</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
