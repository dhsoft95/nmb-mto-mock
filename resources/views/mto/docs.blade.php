<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chungwa MTO API Documentation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0f1117;
            color: #e2e8f0;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: #1a1d27;
            border-right: 1px solid #2d3148;
            padding: 24px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 0 24px 24px;
            border-bottom: 1px solid #2d3148;
            margin-bottom: 16px;
        }

        .sidebar-logo h1 {
            font-size: 18px;
            font-weight: 700;
            color: #f97316;
        }

        .sidebar-logo span {
            font-size: 11px;
            color: #64748b;
            display: block;
            margin-top: 2px;
        }

        .sidebar-nav {
            list-style: none;
        }

        .sidebar-nav li a {
            display: block;
            padding: 10px 24px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar-nav li a:hover,
        .sidebar-nav li a.active {
            color: #f97316;
            background: #1e2235;
            border-left-color: #f97316;
        }

        .sidebar-section {
            padding: 16px 24px 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #475569;
        }

        .main {
            margin-left: 260px;
            flex: 1;
            padding: 40px;
            max-width: 1200px;
        }

        .page-header {
            margin-bottom: 40px;
            padding-bottom: 24px;
            border-bottom: 1px solid #2d3148;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #64748b;
            font-size: 14px;
        }

        .version-badge {
            display: inline-block;
            background: #1e3a5f;
            color: #60a5fa;
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            margin-left: 10px;
            font-weight: 600;
        }

        .section {
            margin-bottom: 48px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #2d3148;
        }

        p {
            color: #94a3b8;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 16px;
        }

        .endpoint-card {
            background: #1a1d27;
            border: 1px solid #2d3148;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .endpoint-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            background: #1e2235;
            border-bottom: 1px solid #2d3148;
        }

        .method-badge {
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 5px;
            letter-spacing: 0.5px;
        }

        .method-post {
            background: #14532d;
            color: #4ade80;
        }

        .endpoint-url {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: #e2e8f0;
            word-break: break-all;
        }

        .endpoint-body {
            padding: 20px;
        }

        .endpoint-body p {
            margin-bottom: 12px;
        }

        .auth-box {
            background: #1a1d27;
            border: 1px solid #2d3148;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 16px;
        }

        .auth-box h4 {
            font-size: 13px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 12px;
        }

        .auth-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .auth-row:last-child {
            margin-bottom: 0;
        }

        .auth-key {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #f97316;
            background: #1e1a14;
            padding: 4px 10px;
            border-radius: 4px;
            min-width: 90px;
        }

        .auth-value {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #94a3b8;
        }

        .params-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .params-table th {
            text-align: left;
            padding: 10px 14px;
            background: #1e2235;
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #2d3148;
        }

        .params-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #1e2235;
            color: #94a3b8;
            vertical-align: top;
        }

        .params-table tr:last-child td {
            border-bottom: none;
        }

        .param-name {
            font-family: 'Courier New', monospace;
            color: #60a5fa;
            font-size: 12px;
        }

        .required-badge {
            font-size: 10px;
            background: #450a0a;
            color: #f87171;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: 600;
        }

        .optional-badge {
            font-size: 10px;
            background: #1c2a1e;
            color: #4ade80;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: 600;
        }

        .code-block {
            background: #0d1117;
            border: 1px solid #2d3148;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            overflow-x: auto;
        }

        .code-block-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .code-block-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
        }

        .code-block pre {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.6;
            color: #e2e8f0;
            white-space: pre-wrap;
        }

        .response-codes {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .response-code-card {
            background: #1a1d27;
            border: 1px solid #2d3148;
            border-radius: 8px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .code-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            flex-shrink: 0;
        }

        .code-00 { background: #14532d; color: #4ade80; }
        .code-01 { background: #1e3a5f; color: #60a5fa; }
        .code-54 { background: #450a0a; color: #f87171; }
        .code-55 { background: #2d1a0e; color: #fb923c; }
        .code-96 { background: #1a1330; color: #c084fc; }

        .code-info h4 {
            font-size: 13px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 2px;
        }

        .code-info p {
            font-size: 12px;
            color: #64748b;
            margin: 0;
        }

        .alert {
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 13px;
            margin-bottom: 16px;
            display: flex;
            gap: 10px;
        }

        .alert-info {
            background: #0f2744;
            border: 1px solid #1e3a5f;
            color: #93c5fd;
        }

        .alert-warning {
            background: #2d1a0e;
            border: 1px solid #431407;
            color: #fdba74;
        }

        .alert-success {
            background: #14532d;
            border: 1px solid #166534;
            color: #4ade80;
        }

        .fsp-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .fsp-card {
            background: #1a1d27;
            border: 1px solid #2d3148;
            border-radius: 8px;
            padding: 12px;
            font-size: 12px;
        }

        .fsp-card .fsp-code {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: #f97316;
            font-size: 13px;
        }

        .fsp-card .fsp-name {
            color: #94a3b8;
            margin-top: 2px;
        }

        .fsp-type-bank { border-left: 3px solid #60a5fa; }
        .fsp-type-mno  { border-left: 3px solid #4ade80; }

        .nin-badge {
            font-family: 'Courier New', monospace;
            background: #1e2235;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
            color: #f97316;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0f1117; }
        ::-webkit-scrollbar-thumb { background: #2d3148; border-radius: 3px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <h1>Chungwa API</h1>
        <span>MTO Integration Docs v1.0</span>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-section">Getting Started</li>
        <li><a href="#introduction" class="active">Introduction</a></li>
        <li><a href="#base-url">Base URL</a></li>
        <li><a href="#authentication">Authentication</a></li>
        <li class="sidebar-section">Endpoints</li>
        <li><a href="#account-lookup">Account Lookup</a></li>
        <li class="sidebar-section">Reference</li>
        <li><a href="#response-codes">Response Codes</a></li>
        <li><a href="#supported-fsps">Supported FSPs</a></li>
    </ul>
</aside>

<main class="main">

    <div class="page-header">
        <h1>Chungwa MTO API <span class="version-badge">v1.0</span></h1>
        <p>API documentation for MTO integration partners.</p>
    </div>

    <!-- Introduction -->
    <div class="section" id="introduction">
        <div class="section-title">Introduction</div>
        <p>
            The Chungwa MTO API enables integration partners to perform account lookups and fund transfers
            through a secure and standardized interface. This documentation covers all available endpoints,
            request and response formats, authentication requirements, and supported FSPs.
        </p>
        <div class="alert alert-warning">
            All requests must include valid authentication headers. Requests without credentials will be rejected.
        </div>
    </div>

    <!-- Base URL -->
    <div class="section" id="base-url">
        <div class="section-title">Base URL</div>
        <p>All API requests should be made to the following base URL:</p>
        <div class="code-block">
            <div class="code-block-header">
                <span class="code-block-label">Test</span>
            </div>
            <pre>https://www.connect.chungwa.co.tz</pre>
        </div>
        <div class="alert alert-info">
            All endpoints are relative to this base URL. Ensure all requests are made over HTTPS.
        </div>
    </div>

    <!-- Authentication -->
    <div class="section" id="authentication">
        <div class="section-title">Authentication</div>
        <p>
            Authentication is handled via custom HTTP headers. Every request must include a
            <code style="color:#f97316">username</code> and <code style="color:#f97316">password</code> header.
        </p>
        <div class="auth-box">
            <h4>Test Credentials</h4>
            <div class="auth-row">
                <span class="auth-key">username</span>
                <span class="auth-value">chungwa90</span>
            </div>
            <div class="auth-row">
                <span class="auth-key">password</span>
                <span class="auth-value">**********</span>
            </div>
        </div>
        <div class="code-block">
            <div class="code-block-header">
                <span class="code-block-label">Request Headers</span>
            </div>
            <pre>Content-Type: application/json
username: chungwa
password: @Dmin2021!</pre>
        </div>
    </div>

    <!-- Account Lookup -->
    <div class="section" id="account-lookup">
        <div class="section-title">Account Lookup</div>

        <div class="endpoint-card">
            <div class="endpoint-header">
                <span class="method-badge method-post">POST</span>
                <span class="endpoint-url">https://www.connect.chungwa.co.tz/api/chungwa/v1.0/customer-lookup</span>
            </div>
            <div class="endpoint-body">
                <p>
                    Lookup an account by identifier (bank account number or mobile number) to retrieve
                    account holder details before initiating a transfer.
                </p>

                <h4 style="color:#f1f5f9; font-size:13px; margin-bottom:12px;">Request Parameters</h4>
                <table class="params-table">
                    <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Type</th>
                        <th>Required</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="param-name">clientID</td>
                        <td>string</td>
                        <td><span class="required-badge">Required</span></td>
                        <td>Unique client identifier assigned to your integration</td>
                    </tr>
                    <tr>
                        <td class="param-name">requestID</td>
                        <td>string</td>
                        <td><span class="required-badge">Required</span></td>
                        <td>Unique request identifier for tracking</td>
                    </tr>
                    <tr>
                        <td class="param-name">identifier</td>
                        <td>string</td>
                        <td><span class="required-badge">Required</span></td>
                        <td>Account or mobile number to lookup</td>
                    </tr>
                    <tr>
                        <td class="param-name">identifierType</td>
                        <td>string</td>
                        <td><span class="required-badge">Required</span></td>
                        <td>Type of identifier: <code style="color:#f97316">BANK</code> or <code style="color:#f97316">MSISDN</code> or <code style="color:#f97316">NIN</code></td>
                    </tr>
                    <tr>
                        <td class="param-name">destinationFsp</td>
                        <td>string</td>
                        <td><span class="optional-badge">Optional</span></td>
                        <td>Accepts numeric code (e.g. <code style="color:#f97316">507</code>) or FSP name (e.g. <code style="color:#f97316">AZAMPESA</code>). Case-insensitive. See Supported FSPs table.</td>
                    </tr>
                    </tbody>
                </table>

                <h4 style="color:#f1f5f9; font-size:13px; margin-bottom:12px; margin-top:20px;">Request Example</h4>
                <div class="code-block">
                    <div class="code-block-header">
                        <span class="code-block-label">JSON Request</span>
                    </div>
                    <pre>POST https://www.connect.chungwa.co.tz/api/chungwa/v1.0/customer-lookup

Headers:
  Content-Type: application/json
  username: chungwa
  password: @Dmin2021!

Body:
{
    "clientID": "client001",
    "requestID": "123456",
    "identifier": "00000121",
    "identifierType": "BANK",
    "destinationFsp": "003"
}</pre>
                </div>

                <h4 style="color:#f1f5f9; font-size:13px; margin-bottom:12px; margin-top:20px;">Response Parameters</h4>
                <table class="params-table">
                    <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Type</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="param-name">responsecode</td>
                        <td>string</td>
                        <td>Transaction status code</td>
                    </tr>
                    <tr>
                        <td class="param-name">responsedescription</td>
                        <td>string</td>
                        <td>Human readable status description</td>
                    </tr>
                    <tr>
                        <td class="param-name">identifierType</td>
                        <td>string</td>
                        <td>Type of the identifier returned</td>
                    </tr>
                    <tr>
                        <td class="param-name">identifier</td>
                        <td>string</td>
                        <td>The account or mobile number</td>
                    </tr>
                    <tr>
                        <td class="param-name">fspId</td>
                        <td>string</td>
                        <td>FSP owning the identifier</td>
                    </tr>
                    <tr>
                        <td class="param-name">fullName</td>
                        <td>string</td>
                        <td>Full name of the account holder</td>
                    </tr>
                    <tr>
                        <td class="param-name">accountCategory</td>
                        <td>string</td>
                        <td><code style="color:#f97316">PERSON</code> or <code style="color:#f97316">BUSINESS</code></td>
                    </tr>
                    <tr>
                        <td class="param-name">accountType</td> 2
                        <td>string</td>
                        <td><code style="color:#f97316">BANK</code> or <code style="color:#f97316">WALLET</code></td>
                    </tr>
                    <tr>
                        <td class="param-name">identity.type</td>
                        <td>string</td>
                        <td>ID type: <code style="color:#f97316">NIN</code> or <code style="color:#f97316">TIN</code></td>
                    </tr>
                    <tr>
                        <td class="param-name">identity.value</td>
                        <td>string</td>
                        <td>ID number without hyphens</td>
                    </tr>
                    </tbody>
                </table>

                <h4 style="color:#f1f5f9; font-size:13px; margin-bottom:12px; margin-top:20px;">Response Examples</h4>

                <div class="code-block">
                    <div class="code-block-header">
                        <span class="code-block-label">Success Response (200)</span>
                    </div>
                    <pre>{
    "responsecode": "00",
    "responsedescription": "SUCCESS",
    "identifierType": "BANK",
    "identifier": "00000121",
    "fspId": "CRDB",
    "fullName": "Andendekisye Shekimweri",
    "accountCategory": "PERSON",
    "accountType": "BANK",
    "identity": {
        "type": "TIN",
        "value": "503123579"
    }
}</pre>
                </div>

                <div class="code-block">
                    <div class="code-block-header">
                        <span class="code-block-label">Not Found Response (404)</span>
                    </div>
                    <pre>{
    "responsecode": "54",
    "responsedescription": "Account not found"
}</pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Response Codes -->
    <div class="section" id="response-codes">
        <div class="section-title">Response Codes</div>
        <div class="response-codes">
            <div class="response-code-card">
                <div class="code-circle code-00">00</div>
                <div class="code-info">
                    <h4>Successful</h4>
                    <p>Transaction completed successfully</p>
                </div>
            </div>
            <div class="response-code-card">
                <div class="code-circle code-01">01</div>
                <div class="code-info">
                    <h4>Pending</h4>
                    <p>Transaction is being processed</p>
                </div>
            </div>
            <div class="response-code-card">
                <div class="code-circle code-54">54</div>
                <div class="code-info">
                    <h4>Failed</h4>
                    <p>Transaction failed or account not found</p>
                </div>
            </div>
            <div class="response-code-card">
                <div class="code-circle code-55">55</div>
                <div class="code-info">
                    <h4>Cancelled</h4>
                    <p>Transaction was cancelled</p>
                </div>
            </div>
            <div class="response-code-card">
                <div class="code-circle code-96">96</div>
                <div class="code-info">
                    <h4>System Error</h4>
                    <p>Upstream provider error, please retry</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Supported FSPs -->
    <div class="section" id="supported-fsps">
        <div class="section-title">Supported FSPs</div>
        <p>The following Financial Service Providers are supported for account lookup and fund transfers. Use either the numeric code or FSP name in the <code style="color:#f97316">destinationFsp</code> field (case-insensitive).</p>

        <h4 style="color:#f1f5f9; font-size:14px; margin-bottom:12px; margin-top:4px;">Banks</h4>
        <table class="params-table" style="margin-bottom:28px;">
            <thead>
            <tr>
                <th>Numeric Code</th>
                <th>FSP Name(s)</th>
                <th>Institution</th>
            </tr>
            </thead>
            <tbody>
            <tr><td class="param-name">003</td><td>CRDB</td><td>CRDB Bank</td></tr>
            <tr><td class="param-name">004</td><td>NMB</td><td>NMB Bank</td></tr>
            <tr><td class="param-name">013</td><td>EXIM</td><td>Exim Bank</td></tr>
            <tr><td class="param-name">015</td><td>NBC</td><td>NBC Bank</td></tr>
            <tr><td class="param-name">006</td><td>STANBIC</td><td>Stanbic Bank</td></tr>
            <tr><td class="param-name">011</td><td>DTB</td><td>Diamond Trust Bank</td></tr>
            <tr><td class="param-name">009</td><td>BOA</td><td>Bank of Africa</td></tr>
            <tr><td class="param-name">020</td><td>ABSA</td><td>ABSA Bank</td></tr>
            <tr><td class="param-name">021</td><td>IMB</td><td>I&amp;M Bank</td></tr>
            <tr><td class="param-name">040</td><td>ECOBANK</td><td>Ecobank Tanzania</td></tr>
            <tr><td class="param-name">046</td><td>AMANA</td><td>Amana Bank</td></tr>
            <tr><td class="param-name">031</td><td>AZANIA</td><td>Azania Bank</td></tr>
            <tr><td class="param-name">024</td><td>DCB</td><td>DCB Commercial Bank</td></tr>
            <tr><td class="param-name">034</td><td>BANCABC</td><td>BancABC</td></tr>
            <tr><td class="param-name">039</td><td>MKOMBOZI</td><td>Mkombozi Bank</td></tr>
            <tr><td class="param-name">048</td><td>TPB</td><td>TPB Bank</td></tr>
            </tbody>
        </table>

        <h4 style="color:#f1f5f9; font-size:14px; margin-bottom:12px;">Mobile Money Operators</h4>
        <table class="params-table">
            <thead>
            <tr>
                <th>Numeric Code</th>
                <th>FSP Name(s)</th>
                <th>Operator</th>
            </tr>
            </thead>
            <tbody>
            <tr><td class="param-name">503</td><td>VODACOM / MPESA</td><td>Vodacom M-Pesa</td></tr>
            <tr><td class="param-name">504</td><td>AIRTEL</td><td>Airtel Money</td></tr>
            <tr><td class="param-name">501</td><td>TIGO / YAS</td><td>Tigo Pesa / Zantel</td></tr>
            <tr><td class="param-name">506</td><td>HALOPESA / HALOTEL</td><td>Halotel HaloPesa</td></tr>
            <tr><td class="param-name">507</td><td>AZAMPESA / AZAM</td><td>Azam Mobile Money</td></tr>
            </tbody>
        </table>
    </div>


</main>

<script>
    const sections = document.querySelectorAll('.section');
    const navLinks = document.querySelectorAll('.sidebar-nav li a');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            if (window.scrollY >= sectionTop) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
</script>

</body>
</html>
