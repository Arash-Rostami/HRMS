@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('smsHandler', () => ({
                openSMSModal: false,
                openSMSToast: false,
                toastMessage: '',
                receptor: '',
                message: '',
                sendSMS() {
                    axios.post('{{ route("send-sms") }}', {
                        message: document.getElementById('smsMessage').value,
                        receptor: this.receptor
                    }, {
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                    })
                        .then(res => {
                            this.toastMessage = 'پیام شما با موفقیت ارسال شد :)';
                            this.openSMSToast = true;
                            setTimeout(() => this.openSMSToast = false, 5000);
                        })
                        .catch(err => {
                            this.toastMessage = 'خطا در ارسال پیام :(';
                            this.openSMSToast = true;
                            setTimeout(() => this.openSMSToast = false, 5000);
                        });

                    this.openSMSModal = false;
                }
            }));
        });
    </script>
@endpush
