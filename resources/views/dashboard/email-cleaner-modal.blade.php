<div class="modal fade text-left modal-borderless" data-bs-backdrop="static" id="note" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 form-group">
                    <p><i class="bi bi-asterisk text-danger"></i> To ensure proper handshaking and validation with SMTP
                        servers to
                        verify
                        emails,
                        please make sure your email address that you entered here adheres to the
                        following standards:</p>
                    <ol>
                        <li>
                            SPF (Sender Policy Framework): Ensure that your domain has a valid SPF
                            record set up. SPF helps prevent email spoofing by specifying which mail
                            servers are authorized to send emails on behalf of your domain.
                        </li>
                        <li>DKIM (DomainKeys Identified Mail): Set up DKIM for your domain. DKIM
                            adds a digital signature to outgoing emails, allowing the receiving
                            server to verify the authenticity of the sender and the integrity of the
                            email's content.
                        </li>
                        <li>DMARC (Domain-based Message Authentication, Reporting, and Conformance):
                            Implement a DMARC policy for your domain. DMARC builds upon SPF and
                            DKIM, providing an extra layer of protection and specifying what actions
                            to take if an email fails authentication checks.
                        </li>
                    </ol>
                   <p>By complying with these standards, your validation will have a higher chance
                        of successful results and lower the risk of ending up in invalid values.
                        <a href="https://www.cloudflare.com/learning/email-security/dmarc-dkim-spf/#:~:text=How%20to%20set%20up%20DMARC,upload%20and%20edit%20DNS%20records."
                        target="_blenk">Please click</a> this article for more details.
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
