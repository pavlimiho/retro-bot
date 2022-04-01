<script type="text/javascript">
    let isLoading = false;
    
    function customAjax(params) {
        if (!isLoading) {
            $.ajax({
                url: params.url,
                type: params.type ? params.type : 'post',
                dataType: params.dataType ? params.dataType : 'json',
                data: params.data,
                beforeSend: function () {
                    isLoading = true;
                    params.beforeSend();
                },
                success: function (response) {
                    params.success(response);

                    isLoading = false;
                    
                },
                error: function (e, textStatus, errorThrown) {
                    isLoading = false;
                    
                    @if (config('app.env') === 'local')
                        writeConsole(e.responseText)
                    @else
                        let response = JSON.parse(e.responseText);
                        if (params.error) {
                            params.error(response);
                        } else if (response.errors) {
                            Swal.fire('Error', response.message, 'error');
                        } else {
                            Swal.fire('Error', 'An error occurred, please try again later', 'error');
                        }
                        
                    @endif
                }
            });
        }
    }
    
    function writeConsole(content) {
        top.consoleRef=window.open('','myconsole',
            'width=750,height=550'
            +',menubar=0'
            +',toolbar=0'
            +',status=0'
            +',scrollbars=1'
            +',resizable=1')

        if (top.consoleRef) { // may be blocked by browser
            top.consoleRef.document.writeln(
                '<html><head><title>Console</title></head>'
                +'<body bgcolor=white onLoad="self.focus()">'
                +content
                +'</body></html>'
            )
            top.consoleRef.document.close()
        }
    }
    
    /**
     * Opens a Boostrap (https://getbootstrap.com/docs/4.0/components/modal/#modal-components) confirmation box
     * @param  {[string]} title      The modal title
     * @param  {[string]} message    The message to use in the modal
     * @param  {[function]} confirmed    Optional. A function to call when the modal is confirmed
     * @param  {[string]} oktext     Optional. Text to use for the 'Ok' button
     * @param  {[function]} confirmed    Optional. A function to call when the modal is closed/canceled
     * @param  {[string]} canceltext Optional. Text to use for the 'Cancel' button
     * @return {[Promise]}            use .then and .catch to handle true/false values
     */
    function confirmMessage(title, message, confirmed, oktext, canceled, canceltext) {
        if (!oktext) oktext = 'Ok'
        if (!canceltext) canceltext = 'Cancel'
        var formattedMessage = "<p>" + message.replace(/\n\n/g, "</p><p>") + "</p>"

        if (!document.getElementById('confirm-message')) {
            jQuery('body').prepend('<div id="confirm-message" class="modal" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">'+title+'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">'+formattedMessage+'</div><div class="modal-footer"><button type="button" class="okbutton btn btn-primary" data-dismiss="modal">'+oktext+'</button><button type="button" class="cancelbutton btn btn-secondary" data-dismiss="modal">'+canceltext+'</button></div></div></div></div>');
        }
        else if (document.getElementById('confirm-message')) {
            // set new text and cancel prior message
            jQuery("#confirm-message .modal-title").text(title);
            jQuery('#confirm-message .modal-body').html(formattedMessage)
            jQuery('#confirm-message .okbutton').html(oktext)
            jQuery('#confirm-message .cancelbutton').html(canceltext)

            // clear data
            jQuery('#confirm-message').data('confirmed',null)
            jQuery('#confirm-message').off('hidden.coreui.modal')
        }

        jQuery('#confirm-message .okbutton').one('click',function(){
            if (typeof confirmed == 'function') confirmed()
        })

        // setup new canceled handlers on hidden
        jQuery('#confirm-message').on('hidden.coreui.modal', function(e) {
            if (canceled && document.activeElement !== document.querySelector('#confirm-message .okbutton')) canceled()
        })

        jQuery('#confirm-message').modal({show: true})
    }
    
    function customDelay(fn, ms) {
        let timer = 0
        return function(...args) {
            clearTimeout(timer)
            timer = setTimeout(fn.bind(this, ...args), ms || 0)
        }
    }
</script>

@stack('scripts')