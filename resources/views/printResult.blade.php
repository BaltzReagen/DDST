<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENARAI SEMAK PENGESANAN</title>
    <style>
        @page {
            margin: 2cm;
            size: A4 portrait;
        }

        body {
            font-family: 'dejavu sans', sans-serif;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
            font-size: 11pt;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 12pt;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            line-height: 1.4;
        }

        .subtitle {
            font-size: 10pt;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        .form-label {
            display: inline-block;
            vertical-align: top;
            width: 100px;
        }

        .form-value {
            display: inline-block;
            border-bottom: 1px solid #000;
            width: 150px;
            min-height: 18px;
            vertical-align: top;
        }

        .form-value-kps {
            display: inline-block;
            border-bottom: 1px solid #000;
            padding-top: 20px;
            width: 150px;
            min-height: 18px;
            vertical-align: top;
        }

        .form-right-label {
            position: absolute;
            left: 350px;
            top: 0;
        }

        .no-break {
            line-height: 0.8; /* Tighter line spacing */
        }

        .form-right-value {
            position: absolute;
            left: 485px;
            width: 150px;
            right: 0;
            border-bottom: 1px solid #000;
            min-height: 19px;
        }

        .form-right-value-kps {
            position: absolute;
            padding-top: 20px;
            left: 485px;
            width: 150px;
            right: 0;
            border-bottom: 1px solid #000;
            min-height: 19px;
        }

        .instruction {
            margin: 25px 0;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 10pt;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .domain-header {
            background-color: #e0e0e0;
            font-weight: normal;
            padding: 8px;
        }

        .col-bil { 
            width: 5%; 
            text-align: center;
        }
        .col-domain { 
            width: 70%; 
        }
        .col-tanda { 
            width: 12%;
            text-align: center;
        }
        .col-catatan { 
            width: 13%;
            text-align: center;
        }

        .footer {
            margin-top: 30px;
        }

        .signature-line {
            margin-top: 20px;
        }

        .page-number {
            text-align: center;
            margin-top: 20px;
            font-size: 10pt;
        }

        .copyright {
            text-align: center;
            font-size: 8pt;
            margin-top: 5px;
        }

        h3 {
            font-size: 12pt;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SENARAI SEMAK PENGESANAN<br>
        @if($screening->child_age_in_months >= 18)
            PERKEMBANGAN KANAK-KANAK 
        @else
            PERKEMBANGAN BAYI 
        @endif
        @if($screening->child_age_in_months >= 24)
            {{ floor($screening->child_age_in_months/12) }} TAHUN
        @elseif($screening->child_age_in_months == 0)
            1 BULAN
        @else
            {{ $screening->child_age_in_months }} BULAN
        @endif</h1>
        <div class="subtitle">
            (Untuk kegunaan {{ $screening->child_age_in_months >= 18 ? 'kanak-kanak' : 'bayi' }} berumur 
            @if($screening->child_age_in_months == 0)
                1
            @else
                {{ $screening->child_age_in_months }}
            @endif
            bulan hingga 
            {{ $screening->child_age_in_months == 0 ? '2' : 
            ($screening->child_age_in_months <= 9 ? $screening->child_age_in_months + 2 : 
            ($screening->child_age_in_months <= 18 ? $screening->child_age_in_months + 5 : 
            $screening->child_age_in_months + 11)) }} bulan bagi tujuan pendidikan)
        </div>
    </div>

    <div class="form-container">
        <div class="form-group">
            <div class="form-label">Nama:</div>
            <div class="form-value">{{ $screening->child_name }}</div>
            <div class="form-right-label no-break">
                Nama ibu<br>bapa/penjaga:<br>
            </div>
            <div class="form-right-value">{{ $screening->fname }}</div>
        </div>

        <div class="form-group">
            <div class="form-label">Tarikh lahir:</div>
            <div class="form-value">{{ \Carbon\Carbon::parse($screening->child_dob)->format('d/m/Y') }}</div>
            <div class="form-right-label">Nombor telefon:</div>
            <div class="form-right-value-kps"></div>
        </div>

        <div class="form-group">
            <div class="form-label">No. K.P/Sijil<br>Kelahiran:</div>
            <div class="form-value-kps"></div>
            <div class="form-right-label">Alamat:</div>
            <div class="form-right-value-kps"></div>
        </div>

        <div class="form-group">
            <div class="form-label">Tempat<br>penilaian:</div>
            <div class="form-value-kps"></div>
        </div>
    </div>

    <div class="instruction">
        Arahan: Tandakan ( / ) untuk kemahiran yang tercapai, atau<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( X ) untuk kemahiran yang tidak tercapai
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-bil">BIL.</th>
                <th class="col-domain">DOMAIN/ITEM</th>
                <th class="col-tanda">TANDA</th>
                <th class="col-catatan">CATATAN</th>
            </tr>
        </thead>
        <tbody>
            @php $currentDomain = ''; $counter = 1; @endphp
            @foreach($milestoneData as $data)
                @if($currentDomain != $data['milestone']->domain)
                    <tr>
                        <td colspan="4" class="domain-header">{{ ucfirst(str_replace('_', ' ', $data['milestone']->domain)) }}</td>
                    </tr>
                    @php $currentDomain = $data['milestone']->domain; @endphp
                @endif
                <tr>
                    <td class="col-bil">{{ $counter++ }}</td>
                    <td>
                        @if($data['milestone']->isCritical)
                            <span class="critical-indicator">*</span>
                        @endif
                        {{ $data['milestone']->description }}
                    </td>
                    <td class="col-tanda">{{ $data['is_achieved'] ? '/' : 'X' }}</td>
                    <td class="col-catatan"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="table-note">* item perkembangan yang penting bagi umur tersebut</div>

    <!-- Previous checklists (Failed ones) -->
    @if(!empty($previousMilestonesData))
        @foreach($previousMilestonesData as $ageGroup => $milestoneGroup)
            <div style="page-break-before: always;">
                <h3 style="margin-top: 20px; margin-bottom: 10px;">
                    SENARAI SEMAK PENGESANAN SEBELUMNYA
                    @if($ageGroup >= 18)
                        PERKEMBANGAN KANAK-KANAK 
                    @else
                        PERKEMBANGAN BAYI 
                    @endif
                    @if($ageGroup >= 24)
                        {{ floor($ageGroup/12) }} TAHUN
                    @else
                        {{ $ageGroup }} BULAN
                    @endif
                    (GAGAL)
                </h3>
                
                <table>
                    <thead>
                        <tr>
                            <th class="col-bil">BIL.</th>
                            <th class="col-perkara">PERKARA</th>
                            <th class="col-tanda">TANDA</th>
                            <th class="col-catatan">CATATAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $currentDomain = ''; 
                            $counter = 1; 
                        @endphp
                        @foreach($milestoneGroup as $data)
                            @if($currentDomain != $data['milestone']->domain)
                                <tr>
                                    <td colspan="4" class="domain-header">{{ ucfirst(str_replace('_', ' ', $data['milestone']->domain)) }}</td>
                                </tr>
                                @php $currentDomain = $data['milestone']->domain; @endphp
                            @endif
                            <tr>
                                <td class="col-bil">{{ $counter++ }}</td>
                                <td>
                                    @if($data['milestone']->isCritical)
                                        <span class="critical-indicator">*</span>
                                    @endif
                                    {{ $data['milestone']->description }}
                                </td>
                                <td class="col-tanda">X</td>
                                <td class="col-catatan"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="table-note">* item perkembangan yang penting bagi umur tersebut</div>
            </div>
        @endforeach
    @endif  

    <div class="footer">
        <div class="signature-line">
            Tandatangan penilai : _________________________ <br>
            Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: _________________________ <br>
            Tarikh penilaian&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: _________________________
        </div>
    </div>

    <div class="page-number">17</div>
    <div class="copyright">© Bahagian Pendidikan Khas, Kementerian Pendidikan Malaysia</div>
</body>
</html>