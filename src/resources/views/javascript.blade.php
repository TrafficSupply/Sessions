<script src="{{ (Request::secure()? 'https': 'http') . '://' . config('trafficsupply.sessions.master_domain') . route('trafficsupply.sessions.get_ts_id', [], false) }}"></script>
<script>
	if (ts_unique_id !== '{{ session('ts_unique_id') }}'){
		var request = new XMLHttpRequest();
		request.open('POST', '{{ route('trafficsupply.sessions.set_ts_id') }}', true);
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		request.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

		request.onreadystatechange = function() {
		  if (this.readyState === 4) {
		    if (this.status >= 200 && this.status < 400) {
		      console.log(['success', this]);
		    } else {
		      console.log(['error', this]);
		    }
		  }
		};

		request.send('ts_unique_id='+ts_unique_id);
		request = null;
	}
</script>