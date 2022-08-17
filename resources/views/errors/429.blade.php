@extends('errors::minimal')

@section('title', __('Too Many Requests'))
<style>
.button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  height:100%;
}

.buttondiv {
    display: flex;
    height: 70px;
    justify-content: center;
    align-items: center;
}
</style>
<div class="container">
    <div class="row">
        <img src="{{asset('error_images/429.svg')}}" alt="{{$exception->getMessage()}}" srcset="" width="100%" height="500px">
    </div>
    <div class="row d-flex justify-content-around">
        <div class="col-md-4">
            <a href="https://wa.me/2347048258922?text=Hello%20there,%20My%20name%20is%20_______.%20I'm%20having%20an%20issue%20while%20shopping%20on%20jollof.com%20I'm%20getting%20error%20messgae%20*{{$exception->getMessage()}}*" target="_blank" class="btn btn-outline-success">Contact Support Team</a>
        </div>
        <div class="col-md-4">
            <a href="mailto:support@jollof.com" class="btn btn-outline-success">MAIL US @ support@jollof.com</a>
        </div>
        <div class="col-md-4">
            <a href="{{route('index')}}" class="btn btn-outline-success">GO BACK HOME</a>
        </div>
    </div>
    
</div>
