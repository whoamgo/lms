<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', 'Georgia', serif;
            background: white;
            width: 8.27in;
            height: 11.69in;
            position: relative;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }
        
        .certificate-container {
            width: 100%;
            height: 100%;
            position: relative;
            background: white;
            padding: 80px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        /* Decorative Corner Shapes */
        .cert-shape-top-left {
            position: absolute;
            top: 0;
            left: 0;
            width: 250px;
            height: 250px;
            z-index: 1;
        }
        
        .cert-shape-top-left-outer {
            position: absolute;
            top: 0;
            left: 0;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            clip-path: polygon(0 0, 100% 0, 0 100%);
        }
        
        .cert-shape-top-left-inner {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            clip-path: polygon(0 0, 100% 0, 0 100%);
        }
        
        .cert-shape-bottom-right {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 250px;
            height: 250px;
            z-index: 1;
        }
        
        .cert-shape-bottom-right-outer {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            clip-path: polygon(100% 0, 100% 100%, 0 100%);
        }
        
        .cert-shape-bottom-right-inner {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            clip-path: polygon(100% 0, 100% 100%, 0 100%);
        }
        
        .certificate-content {
            position: relative;
            text-align: center;
            width: 100%;
            max-width: 600px;
            z-index: 2;
        }
        
        .cert-association {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 30px;
            letter-spacing: 2px;
            font-weight: 500;
            font-family: Arial, sans-serif;
        }
        
        .cert-main-title {
            font-size: 64px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
            letter-spacing: 4px;
            line-height: 1.2;
            font-family: 'Times New Roman', 'Georgia', serif;
        }
        
        .cert-subtitle {
            font-size: 28px;
            color: #111827;
            margin-bottom: 50px;
            letter-spacing: 2px;
            font-weight: 700;
            font-family: 'Times New Roman', 'Georgia', serif;
        }
        
        .cert-presentation-bar {
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            color: white;
            padding: 14px 30px;
            border-radius: 6px;
            display: inline-block;
            margin: 0 auto 30px;
            font-size: 14px;
            font-weight: 500;
            font-family: Arial, sans-serif;
        }
        
        .cert-recipient-name {
            font-size: 42px;
            font-weight: 600;
            color: #111827;
            margin: 30px 0 40px 0;
            font-family: 'Georgia', 'Times New Roman', serif;
            font-style: italic;
            text-decoration: underline;
            text-decoration-thickness: 2px;
            text-underline-offset: 8px;
            line-height: 1.4;
        }
        
        .cert-description {
            margin: 40px auto;
            color: #2563eb;
            font-size: 14px;
            line-height: 1.8;
            max-width: 550px;
            font-family: Arial, sans-serif;
        }
        
        .cert-description p {
            margin: 10px 0;
        }
        
        .cert-diploma-badge {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin: 40px 0 30px 0;
            letter-spacing: 2px;
            font-family: 'Times New Roman', 'Georgia', serif;
            text-transform: uppercase;
        }
        
        .cert-ribbon-icon {
            margin: 30px auto;
            width: 120px;
            height: 120px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .cert-ribbon-badge {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            border-radius: 50%;
            position: relative;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
        .cert-ribbon-badge::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 90px;
            height: 30px;
            background: linear-gradient(135deg, #93c5fd 0%, #60a5fa 100%);
            border-radius: 50% 50% 0 0;
            clip-path: polygon(0 0, 100% 0, 90% 100%, 10% 100%);
        }
        
        .cert-ribbon-badge::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 40px;
            background: white;
            clip-path: polygon(20% 0, 80% 0, 100% 100%, 0 100%);
        }
        
        .cert-signatures {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 80px;
            padding: 0 40px;
        }
        
        .cert-signature-left,
        .cert-signature-right {
            flex: 1;
            text-align: center;
        }
        
        .cert-signature-name {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-style: italic;
            font-size: 18px;
            color: #111827;
            margin-bottom: 10px;
            text-decoration: underline;
            text-decoration-thickness: 1px;
        }
        
        .cert-signature-role {
            font-size: 12px;
            color: #4b5563;
            font-weight: 500;
            letter-spacing: 1px;
            font-family: Arial, sans-serif;
            text-transform: uppercase;
        }
        
        .cert-seal-center {
            width: 80px;
            height: 80px;
            margin: 0 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Decorative Corner Shapes -->
        <div class="cert-shape-top-left">
            <div class="cert-shape-top-left-outer"></div>
            <div class="cert-shape-top-left-inner"></div>
        </div>
        <div class="cert-shape-bottom-right">
            <div class="cert-shape-bottom-right-outer"></div>
            <div class="cert-shape-bottom-right-inner"></div>
        </div>
        
        <!-- Certificate Content -->
        <div class="certificate-content">
            <div class="cert-association">• GINGER PLANT ASSOSIATION •</div>
            <div class="cert-main-title">CERTIFICATE</div>
            <div class="cert-subtitle">OF COMPLETION</div>
            
            <div class="cert-presentation-bar">
                This certificate is proudly presented to
            </div>
            
            <div class="cert-recipient-name">
                {{ ucwords(strtolower($certificate->student->name)) }}
            </div>
            
            <div class="cert-description">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
            </div>
            
            <div class="cert-diploma-badge">DIPLOMA</div>
            
            <div class="cert-ribbon-icon">
                <div class="cert-ribbon-badge"></div>
            </div>
            
            <div class="cert-signatures">
                <div class="cert-signature-left">
                    <div class="cert-signature-name">P. Ann ORecital</div>
                    <div class="cert-signature-role">DIRECTOR</div>
                </div>
                <div class="cert-seal-center">
                    <div class="cert-ribbon-badge" style="width: 60px; height: 60px;"></div>
                </div>
                <div class="cert-signature-right">
                    <div class="cert-signature-name">Lee A. Sun</div>
                    <div class="cert-signature-role">TRAINER</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

