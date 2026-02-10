<?php
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, "https://u230752.gluwebsite.nl/wordpress/wp-json/wp/v2/posts?categories=8&per_page=50");

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);

$jobs = json_decode($response, true);

curl_close($curl);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="icon" type="image/png" href="/vacatures/assets/img/favicon.png">
    <link rel="stylesheet" href="/vacatures/assets/css/general.css">
    <link rel="stylesheet" href="/vacatures/assets/css/home.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
</head>

<body>
    <?php include "assets/php/header.php"; ?>
    <main>

        <section id="intro-section">
            <div id="intro-content" style="margin-top: -10%;">
                <h1 id="intro-title">Join the club!</h1>
                <p id="intro-desc">Je zult een leuke, leerzame en enthousiaste werkplek krijgen bij ons!</p>
                <a id="intro-vac-btn" href="#jobs-section">
                    Bekijk Vacatures
                    <svg width="91" height="6" viewBox="0 0 91 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 3H91" stroke="black" stroke-width="5" />
                    </svg>
                </a>
            </div>
            <img id="pointer-circle" src="/vacatures/assets/img/home/test.png" alt="test">
        </section>
<br><br>

        <section id="application-section">
            <div id="apply-content">
                <h2 id="apply-title">Sollicitatie Procedure</h2>
                <p>Nu vraag je jezelf waarschijnlijk af; HOE kom ik bij het Bureau?
                    Allereerst vragen wij om te
                    solliciteren op 1 van de vacatures die hieronder zijn te vinden. Hiervoor heb je in ieder geval het
                    volgende nodig:</p>
                <ul id="application-req">
                    <li>Sollicitatie brief (Motivatie brief)</li>
                    <li>Curriculum Vitea (C.V.)</li>
                    <li>Een portfolio met eigen werk</li>
                </ul>
                <br>
                <p>Bij het starten van Het Bureau zit je in een bepaald Level.</p>
            
                <div id="levels-container">
                  <a id="levels-link-btn" style="border-color:#9B534D">
                    <p>Junior</p>
                  </a> <br>
                  <a id="levels-link-btn" style="border-color:#3F6F54">
                    <p>Medior</p>
                  </a>
                  <a id="levels-link-btn" style="border-color:#755B48">
                    <p>Senior</p>
                  </a>
                </div>

                <!-- <a id="levels-link-btn" href="#">
                    Lees hier over verdere levels!
                    <svg width="91" height="6" viewBox="0 0 91 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 3H91" stroke="white" stroke-width="5" />
                    </svg>
                </a> -->
                <p>Nadat je je sollicitatie in orde hebt gemaakt ga je werken aan een ON-BOARDING opdracht in een groep.
                    Deze opdracht zal door de coaches van Het Bureau worden toegewezen.</p>
                <p>Deze opdracht kan 2 a 3 weken (1 dag per week) duren.</p>
                <p>Na het afronden van deze opdracht zit je met coaches en/of medewerkers van het Bureau om tafel om te
                    kijken wat je ervan gebakken hebt! Neem dan ook alles mee van je sollicitatie!</p>
            </div>
        </section>

        <section id="application2-section">
            <div id="application2-content">
                <a id="application2-vac-btn" href="#jobs-section">
                    Bekijk Vacatures
                    <svg width="91" height="6" viewBox="0 0 91 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 3H91" stroke="black" stroke-width="5" />
                    </svg></a>
                <h2 id="application2-title">Studenten voor</h2>
                <p id="application2-title2">echte klanten</p>
            </div>
        </section>

        <section id="job-info-section">
            <div id="job-info-desc">
                <h3>Balance is everything</h3>
                <p>Naast een leuke werkplek en gezellige collega's vinden wij het belangrijk dat je als lerende
                    professional een goede balans vindt tussen werken en plezier. Dan ben je als professional een stuk
                    creatiever. De volgende punten zullen je kunnen helpen;</p>
            </div>
            <div id="info-icons-container">
                <div class="info-icon-container">
                    <svg class="job-info-icon" viewBox="0 0 190 128" fill="none" xmlns="http://www.w3.org/2000/svg"
                        style="width: 220px">
                        <path
                            d="M158.333 111.5C167.042 111.5 174.167 104.375 174.167 95.6667V16.5001C174.167 7.79175 167.042 0.666748 158.333 0.666748H31.6667C22.9583 0.666748 15.8333 7.79175 15.8333 16.5001V95.6667C15.8333 104.375 22.9583 111.5 31.6667 111.5H0V127.333H190V111.5H158.333ZM31.6667 16.5001H158.333V95.6667H31.6667V16.5001Z"
                            fill="#5B5B5B" />
                    </svg>
                    <p>Gebruik eigen laptop</p>
                </div>
                <div class="info-icon-container">
                    <svg class="job-info-icon" viewBox="0 0 124 148" fill="none" xmlns="http://www.w3.org/2000/svg"
                        style="width: 150px">
                        <path
                            d="M62 0.5C31 0.5 0 4.375 0 31.5V105.125C0 120.082 12.1675 132.25 27.125 132.25L18.2125 141.162C17.677 141.709 17.3151 142.401 17.1726 143.153C17.0301 143.905 17.1132 144.682 17.4116 145.386C17.7099 146.091 18.2102 146.691 18.8492 147.112C19.4882 147.532 20.2375 147.755 21.0025 147.75H29.45C30.4575 147.75 31.465 147.363 32.1625 146.588L46.5 132.25H77.5L91.8375 146.588C92.535 147.285 93.5425 147.75 94.55 147.75H102.998C106.485 147.75 108.19 143.565 105.71 141.162L96.875 132.25C111.833 132.25 124 120.082 124 105.125V31.5C124 4.375 93 0.5 62 0.5ZM27.125 116.75C20.6925 116.75 15.5 111.558 15.5 105.125C15.5 98.6925 20.6925 93.5 27.125 93.5C33.5575 93.5 38.75 98.6925 38.75 105.125C38.75 111.558 33.5575 116.75 27.125 116.75ZM54.25 62.5H15.5V31.5H54.25V62.5ZM96.875 116.75C90.4425 116.75 85.25 111.558 85.25 105.125C85.25 98.6925 90.4425 93.5 96.875 93.5C103.308 93.5 108.5 98.6925 108.5 105.125C108.5 111.558 103.308 116.75 96.875 116.75ZM108.5 62.5H69.75V31.5H108.5V62.5Z"
                            fill="#5B5B5B" />
                    </svg>
                    <p>Makkelijk te bereiken met OV</p>
                </div>
                <div class="info-icon-container">
                    <svg class="job-info-icon" viewBox="0 0 168 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M103.75 131.775C120.612 129.162 139.375 127.5 159.167 127.5V159.167H24.5833C24.5833 154.021 49.9167 142.225 87.9167 134.625V83.1666C81.2667 85.1458 75.6458 89.5791 72.0833 95.4374C69.628 91.3293 66.149 87.9283 61.9862 85.5667C57.8235 83.2051 53.1193 81.9636 48.3333 81.9636C43.5473 81.9636 38.8432 83.2051 34.6804 85.5667C30.5177 87.9283 27.0387 91.3293 24.5833 95.4374C24.8208 67.0958 52.2917 43.8208 87.9167 40.7333V40.4166C87.9167 38.317 88.7507 36.3033 90.2354 34.8187C91.7201 33.334 93.7337 32.4999 95.8333 32.4999C97.933 32.4999 99.9466 33.334 101.431 34.8187C102.916 36.3033 103.75 38.317 103.75 40.4166V40.7333C139.375 43.8208 166.767 67.0958 167.083 95.4374C164.628 91.3293 161.149 87.9283 156.986 85.5667C152.823 83.2051 148.119 81.9636 143.333 81.9636C138.547 81.9636 133.843 83.2051 129.68 85.5667C125.518 87.9283 122.039 91.3293 119.583 95.4374C116.021 89.5791 110.4 85.1458 103.75 83.0874V131.775ZM40.4167 0.833252C40.4167 6.03141 39.3928 11.1787 37.4036 15.9811C35.4143 20.7836 32.4986 25.1472 28.823 28.8229C25.1473 32.4985 20.7837 35.4142 15.9812 37.4035C11.1787 39.3927 6.03149 40.4166 0.833328 40.4166V0.833252H40.4167Z"
                            fill="#5B5B5B" />
                    </svg>
                    <p>Flexibele werktijden</p>
                </div>
                <div class="info-icon-container">
                    <svg class="job-info-icon" viewBox="0 0 190 190" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M174.072 102.798L134.702 63.4283C140.597 63.2309 146.499 63.363 152.38 63.8242C157.903 64.2032 163.102 66.5685 167.017 70.4831C170.931 74.3977 173.297 79.5969 173.676 85.12C174.087 90.3767 174.309 96.4092 174.072 102.798Z"
                            fill="#5B5B5B" />
                        <path
                            d="M85.12 173.684C79.5957 173.304 74.3954 170.938 70.4807 167.022C66.5659 163.106 64.2014 157.904 63.8242 152.38C63.3633 146.502 63.2312 140.603 63.4283 134.71L102.79 174.072C96.4092 174.309 90.3767 174.095 85.12 173.684Z"
                            fill="#5B5B5B" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M82.0642 82.072C92.0392 72.097 105.735 67.1253 119.383 64.8928L172.599 118.117C170.382 131.773 165.411 145.453 155.436 155.436C145.453 165.411 131.765 170.374 118.109 172.599L64.9008 119.391C67.1175 105.735 72.0892 92.047 82.0642 82.072ZM118.513 94.7624C119.626 93.6505 121.135 93.026 122.708 93.026C124.282 93.026 125.791 93.6505 126.904 94.7624L130.625 98.4832L134.346 94.7624C134.889 94.1791 135.545 93.7112 136.273 93.3866C137.002 93.0621 137.788 92.8876 138.585 92.8736C139.382 92.8595 140.174 93.0061 140.913 93.3048C141.653 93.6034 142.324 94.0479 142.888 94.6117C143.452 95.1755 143.897 95.8471 144.195 96.5864C144.494 97.3257 144.64 98.1176 144.626 98.9149C144.612 99.7121 144.438 100.498 144.113 101.227C143.789 101.955 143.321 102.61 142.738 103.154L139.017 106.875L142.738 110.596C143.321 111.139 143.789 111.795 144.113 112.523C144.438 113.251 144.612 114.038 144.626 114.835C144.64 115.632 144.494 116.424 144.195 117.163C143.897 117.903 143.452 118.574 142.888 119.138C142.324 119.702 141.653 120.146 140.913 120.445C140.174 120.744 139.382 120.89 138.585 120.876C137.788 120.862 137.002 120.688 136.273 120.363C135.545 120.039 134.889 119.571 134.346 118.987L130.625 115.267L127.142 118.75L130.863 122.471C131.446 123.014 131.914 123.67 132.238 124.398C132.563 125.126 132.737 125.913 132.751 126.71C132.765 127.507 132.619 128.299 132.32 129.038C132.022 129.778 131.577 130.449 131.013 131.013C130.449 131.577 129.778 132.021 129.038 132.32C128.299 132.619 127.507 132.765 126.71 132.751C125.913 132.737 125.127 132.563 124.398 132.238C123.67 131.914 123.014 131.446 122.471 130.862L118.75 127.142L115.267 130.625L118.987 134.346C119.571 134.889 120.039 135.545 120.363 136.273C120.688 137.001 120.862 137.788 120.876 138.585C120.89 139.382 120.744 140.174 120.445 140.913C120.147 141.653 119.702 142.324 119.138 142.888C118.574 143.452 117.903 143.896 117.163 144.195C116.424 144.494 115.632 144.64 114.835 144.626C114.038 144.612 113.252 144.438 112.523 144.113C111.795 143.789 111.139 143.321 110.596 142.737L106.875 139.017L103.154 142.737C102.611 143.321 101.955 143.789 101.227 144.113C100.498 144.438 99.7122 144.612 98.915 144.626C98.1177 144.64 97.3258 144.494 96.5865 144.195C95.8472 143.896 95.1756 143.452 94.6118 142.888C94.048 142.324 93.6035 141.653 93.3049 140.913C93.0062 140.174 92.8596 139.382 92.8736 138.585C92.8877 137.788 93.0622 137.001 93.3867 136.273C93.7113 135.545 94.1791 134.889 94.7625 134.346L98.4833 130.625L94.7625 126.904C94.1791 126.361 93.7113 125.705 93.3867 124.977C93.0622 124.248 92.8877 123.462 92.8736 122.665C92.8596 121.868 93.0062 121.076 93.3049 120.336C93.6035 119.597 94.048 118.926 94.6118 118.362C95.1756 117.798 95.8472 117.353 96.5865 117.055C97.3258 116.756 98.1177 116.609 98.915 116.624C99.7122 116.638 100.498 116.812 101.227 117.137C101.955 117.461 102.611 117.929 103.154 118.512L106.875 122.233L110.358 118.75L106.638 115.029C106.054 114.485 105.586 113.83 105.262 113.102C104.937 112.373 104.763 111.587 104.749 110.79C104.735 109.993 104.881 109.201 105.18 108.461C105.478 107.722 105.923 107.051 106.487 106.487C107.051 105.923 107.722 105.478 108.462 105.18C109.201 104.881 109.993 104.734 110.79 104.749C111.587 104.763 112.373 104.937 113.102 105.262C113.83 105.586 114.486 106.054 115.029 106.637L118.75 110.358L122.233 106.875L118.513 103.154C117.401 102.041 116.776 100.532 116.776 98.9582C116.776 97.3848 117.401 95.8757 118.513 94.7624Z"
                            fill="#5B5B5B" />
                        <path
                            d="M46.9617 83.1092C40.4779 72.9521 33.5271 66.2863 28.2783 62.1934C26.2696 60.608 24.1534 59.1637 21.945 57.8709C21.265 57.4757 20.5705 57.106 19.8629 56.7625L19.7917 56.7229L17.3217 55.6384C15.6012 62.8292 15.417 70.3021 16.7811 77.569C18.1453 84.8358 21.0271 91.7331 25.2383 97.8104C32.0011 107.634 41.966 114.803 53.4296 118.093L53.5879 118.133C53.5879 118.133 54.0708 112.702 54.815 109.305C55.3533 106.812 55.8996 105.11 56.5567 103.012C54.162 96.0154 50.938 89.331 46.9538 83.1013M76.2137 26.22C77.9554 33.1392 81.3042 42.6392 87.7879 52.8042C89.556 55.5698 91.3425 58.082 93.1475 60.3409C98.3065 57.8942 103.727 56.0429 109.305 54.823C112.211 54.1659 116.81 53.485 116.81 53.485L116.779 53.3663C115.198 47.9112 112.737 42.7505 109.495 38.0871C105.47 32.2443 100.281 27.2969 94.2521 23.5558C88.2236 19.8147 81.4865 17.3607 74.4642 16.348C74.4958 16.7966 74.5565 17.3692 74.6462 18.0659C74.8837 19.9659 75.3508 22.7684 76.2137 26.22ZM62.5812 16.8309L62.5258 16.0471C53.6106 16.8763 45.0744 20.0531 37.7862 25.2542C30.8384 30.1635 25.2161 36.7188 21.4225 44.3334L24.5337 45.7029H24.5496L24.5733 45.7188L24.6446 45.7505L24.8504 45.8455L25.5312 46.178C26.0854 46.463 26.8771 46.8746 27.835 47.4367C29.7587 48.545 32.4187 50.255 35.5142 52.6617C41.6892 57.483 49.6296 65.1305 56.9367 76.5859C59.3592 80.3859 61.4017 84.1067 63.1117 87.6771C65.9647 82.5389 69.5191 77.8228 73.6725 73.6646C76.428 70.9192 79.4305 68.4334 82.6421 66.2388C81.0112 64.1066 79.4015 61.7949 77.8129 59.3038C71.8523 50.0203 67.4231 39.8389 64.695 29.1492C63.8891 25.9968 63.2784 22.7976 62.8662 19.57C62.7484 18.6569 62.6534 17.7488 62.5812 16.8309Z"
                            fill="#5B5B5B" />
                    </svg>
                    <p>Sportieve activeiten</p>
                </div>
                <div class="info-icon-container">
                    <svg class="job-info-icon" viewBox="0 0 155 155" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M77.5 0.71875C57.1363 0.71875 37.6067 8.80818 23.2075 23.2075C8.80818 37.6067 0.71875 57.1363 0.71875 77.5V116.875C0.71875 117.085 0.72925 117.295 0.75025 117.505V117.899C0.726625 127.963 5.491 139.019 16.2089 143.492L16.768 143.729C17.6343 144.075 18.5005 144.674 19.6188 145.697C20.17 146.201 20.7055 146.737 21.3512 147.375L21.4142 147.438C22.0442 148.068 22.7924 148.816 23.5956 149.525C25.2021 150.966 27.3284 152.58 30.1319 153.509C33.0456 154.47 36.1956 154.541 39.6449 153.683C45.3385 152.265 49.6146 147.761 51.2132 142.232C51.9141 139.799 51.9141 136.972 51.9062 133.696V101.456C51.9062 99.2114 51.9062 97.2977 51.8275 95.7227C51.7767 94.0458 51.4931 92.384 50.9849 90.7851C49.1736 85.4065 44.7951 81.154 39.1409 79.9412C35.8422 79.1559 32.3875 79.3336 29.1869 80.4531C26.2731 81.5005 24.0524 83.2409 22.3356 84.8474C21.3906 85.7136 20.2173 86.95 19.2565 87.9659L17.965 89.3046C16.9856 90.3573 15.8518 91.2548 14.6024 91.9664C13.8884 92.3339 13.198 92.7329 12.5312 93.1634V77.5C12.5312 68.9682 14.2117 60.5199 17.4767 52.6375C20.7417 44.7552 25.5272 37.5931 31.5602 31.5602C37.5931 25.5272 44.7552 20.7417 52.6375 17.4767C60.5199 14.2117 68.9682 12.5312 77.5 12.5312C86.0318 12.5312 94.4801 14.2117 102.362 17.4767C110.245 20.7417 117.407 25.5272 123.44 31.5602C129.473 37.5931 134.258 44.7552 137.523 52.6375C140.788 60.5199 142.469 68.9682 142.469 77.5V92.179C141.133 91.3191 139.713 90.5962 138.232 90.0212C137.169 89.5463 136.202 88.8788 135.381 88.0525C134.83 87.5485 134.294 87.013 133.649 86.3751L133.586 86.3121C132.878 85.5967 132.15 84.9008 131.404 84.2252C129.52 82.465 127.296 81.109 124.868 80.2405C121.954 79.2797 118.804 79.2089 115.355 80.0672C109.661 81.4847 105.385 85.9892 103.787 91.5175C103.086 93.9509 103.094 96.778 103.094 100.062V132.294C103.094 134.539 103.094 136.452 103.173 138.027C103.267 139.665 103.464 141.319 104.015 142.965C105.826 148.343 110.205 152.596 115.859 153.809C119.505 154.596 122.813 154.384 125.813 153.297C128.727 152.249 130.948 150.509 132.664 148.903C133.609 148.036 134.783 146.8 135.743 145.792C136.255 145.249 136.712 144.768 137.035 144.453C138.013 143.395 139.147 142.492 140.398 141.776C149.139 137.263 154.218 128.199 154.242 118.655V117.529L154.281 116.875V77.5C154.281 57.1363 146.192 37.6067 131.793 23.2075C117.393 8.80818 97.8637 0.71875 77.5 0.71875Z"
                            fill="#5B5B5B" />
                    </svg>
                    <p>Spotify playlist aanvullen</p>
                </div>
                <div class="info-icon-container">
                    <svg class="job-info-icon" viewBox="0 0 161 167" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M80.9138 0.947998H80.0862C72.9316 0.947998 66.9708 0.947998 62.2436 1.58467C57.2457 2.25317 52.7334 3.73342 49.1123 7.35446C45.4833 10.9835 44.0031 15.4958 43.3346 20.4857C42.6979 25.2209 42.6979 31.1897 42.6979 38.3363V38.957C26.6141 39.4823 16.9527 41.3604 10.2438 48.0772C0.916656 57.3965 0.916656 72.4059 0.916656 102.417C0.916656 132.428 0.916656 147.437 10.2438 156.756C19.571 166.075 34.5724 166.083 64.5833 166.083H96.4167C126.428 166.083 141.437 166.083 150.756 156.756C160.075 147.429 160.083 132.428 160.083 102.417C160.083 72.4059 160.083 57.3965 150.756 48.0772C144.047 41.3604 134.386 39.4823 118.302 38.957V38.3363C118.302 31.1897 118.302 25.2209 117.665 20.4937C116.997 15.4958 115.517 10.9835 111.888 7.36241C108.267 3.73341 103.754 2.25317 98.7564 1.58467C94.0292 0.947998 88.0604 0.947998 80.9138 0.947998ZM106.365 38.766V38.7501C106.365 31.0782 106.349 25.9212 105.839 22.0774C105.338 18.4086 104.486 16.8328 103.452 15.7982C102.417 14.7637 100.841 13.9121 97.1647 13.4107C93.3288 12.9014 88.1718 12.8855 80.5 12.8855C72.8282 12.8855 67.6712 12.9014 63.8273 13.4187C60.1585 13.9121 58.5827 14.7637 57.5482 15.8062C56.5136 16.8487 55.662 18.4086 55.1607 22.0774C54.6593 25.9212 54.6354 31.0782 54.6354 38.7501V38.766C57.7498 38.7554 61.0657 38.7501 64.5833 38.7501H96.4167C99.9289 38.7501 103.245 38.7554 106.365 38.766ZM120.292 62.6251C120.292 64.7358 119.453 66.76 117.961 68.2525C116.468 69.7449 114.444 70.5834 112.333 70.5834C110.223 70.5834 108.198 69.7449 106.706 68.2525C105.213 66.76 104.375 64.7358 104.375 62.6251C104.375 60.5144 105.213 58.4902 106.706 56.9977C108.198 55.5052 110.223 54.6667 112.333 54.6667C114.444 54.6667 116.468 55.5052 117.961 56.9977C119.453 58.4902 120.292 60.5144 120.292 62.6251ZM48.6667 70.5834C50.7773 70.5834 52.8016 69.7449 54.294 68.2525C55.7865 66.76 56.625 64.7358 56.625 62.6251C56.625 60.5144 55.7865 58.4902 54.294 56.9977C52.8016 55.5052 50.7773 54.6667 48.6667 54.6667C46.556 54.6667 44.5317 55.5052 43.0393 56.9977C41.5468 58.4902 40.7083 60.5144 40.7083 62.6251C40.7083 64.7358 41.5468 66.76 43.0393 68.2525C44.5317 69.7449 46.556 70.5834 48.6667 70.5834Z"
                            fill="#5B5B5B" />
                    </svg>
                    <p>Veel vakantiedagen</p>
                </div>
            </div>
        </section>

        <section id="jobs-section">
            <div id="jobs-slide-menu">
                <?php 
                // Get jobs from database
                require_once 'db_connect.php';
                $result = $conn->query("SELECT * FROM bureau_vacatures ORDER BY id");
                
                if ($result && $result->num_rows > 0) {
                    foreach ($result->fetch_all(MYSQLI_ASSOC) as $job) {
                        $jobId = $job['id'];
                        $jobTitle = htmlspecialchars($job['title']);
                        $location = htmlspecialchars($job['location']);
                        $jobType = htmlspecialchars($job['type']);
                        $imageUrl = !empty($job['image']) ? '/vacatures' . htmlspecialchars($job['image']) : '/vacatures/assets/img/placeholder.png';
                ?>
                    <div class="job-card">
                        <img class="job-img" src="<?php echo htmlspecialchars($imageUrl); ?>" alt="<?php echo htmlspecialchars($jobTitle); ?>" width="220px">
                        <p class="job-title"><?php echo htmlspecialchars($jobTitle); ?></p>
                        <p class="job-loc"><?php echo htmlspecialchars($location); ?></p>
                        <a href="/vacatures/vacature?id=<?php echo $jobId; ?>">
                            <svg width="90" height="90" viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M76.365 47.6513C77.068 46.9481 77.463 45.9944 77.463 45.0001C77.463 44.0057 77.068 43.052 76.365 42.3488L55.1513 21.1351C54.8053 20.7769 54.3915 20.4912 53.934 20.2947C53.4765 20.0982 52.9844 19.9947 52.4865 19.9904C51.9886 19.986 51.4948 20.0809 51.0339 20.2695C50.5731 20.458 50.1544 20.7365 49.8023 21.0886C49.4502 21.4407 49.1717 21.8594 48.9832 22.3202C48.7946 22.7811 48.6997 23.2749 48.7041 23.7728C48.7084 24.2707 48.8118 24.7628 49.0084 25.2203C49.2049 25.6778 49.4906 26.0916 49.8488 26.4376L64.6613 41.2501L15 41.2501C14.0054 41.2501 13.0516 41.6452 12.3484 42.3484C11.6451 43.0517 11.25 44.0055 11.25 45.0001C11.25 45.9946 11.6451 46.9485 12.3484 47.6517C13.0516 48.355 14.0054 48.7501 15 48.7501L64.6613 48.7501L49.8488 63.5626C49.1657 64.2698 48.7877 65.2171 48.7962 66.2003C48.8048 67.1836 49.1992 68.1241 49.8944 68.8194C50.5897 69.5147 51.5303 69.909 52.5135 69.9176C53.4967 69.9261 54.444 69.5482 55.1513 68.8651L76.365 47.6513Z"
                                    fill="black" />
                            </svg>
                        </a>
                        <p class="job-availability"><?php echo htmlspecialchars($jobType); ?></p>
                    </div>
                <?php 
                    }
                } else {
                    echo '<p style="padding: 20px; text-align: center;">Geen vacatures beschikbaar.</p>';
                }
                ?>
            </div>
        </section>

        <section id="playlist-section">
            <iframe id="spotify-iframe" style="border-radius:12px"
                src="https://open.spotify.com/embed/playlist/37i9dQZEVXbNG2KDcFcKOF?utm_source=generator"
                frameBorder="0" allowfullscreen=""
                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture"
                loading="lazy"></iframe>
        </section>

    </main>
    <?php include "assets/php/footer.php"; ?>
    
    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = entry.target.classList.contains('info-icon-container') ? 'scale(1)' : 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe sections for fade-in on scroll
        document.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('#application2-section, #job-info-section, #playlist-section');
            sections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                section.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
                observer.observe(section);
            });

            // Animate info icons
            const infoIcons = document.querySelectorAll('.info-icon-container');
            infoIcons.forEach((icon, index) => {
                icon.style.opacity = '0';
                icon.style.transform = 'scale(0.8)';
                icon.style.transition = `opacity 0.5s ease-out ${index * 0.15}s, transform 0.5s ease-out ${index * 0.15}s`;
                observer.observe(icon);
            });
        });
    </script>
</body>

</html>