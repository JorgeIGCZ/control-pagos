
<form method="POST" action="{{ route('logout') }}" style="text-align: center;padding: 7%;">
	@csrf
	<x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();" style="font-weight: 700;color: #6c7277;">
		<i class="fas fa-sign-out-alt"></i> {{ __('Cerrar Sesión') }}
	</x-jet-dropdown-link>
</form>