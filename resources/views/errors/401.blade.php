@extends('errors::minimal')

@section('title', __('Unauthorized'))
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
}

.buttondiv {
    display: flex;
  justify-content: center;
  align-items: center;
}
</style>
<div>
    <img src="{{asset('error_images/401.svg')}}" alt="{{$exception->getMessage()}}" srcset="" width="100%" height="500px">
    
    <div class="buttondiv">
        <a href="{{route('index')}}" class="btn btn-outline-success">GO BACK HOME</a>
    </div>
</div>

