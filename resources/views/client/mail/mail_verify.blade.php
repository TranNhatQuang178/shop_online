
<p>Hi, <strong>{{ $customer->name }}</strong></p>
<button><a href="{{ route('verify', $customer->remember_token) }}">Bấm vào đây để xác nhận</a></button>

<p>Nếu không phải bạn. Vui lòng bỏ qua thư này.</p>