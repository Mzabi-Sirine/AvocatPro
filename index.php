

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cabinet Avocat Droit Étranger</title>
    <style>
        body {
            margin: 0;
            background-color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.5;
        }
        header {
            background-color: #002b55;
            color: white;
            padding: 20px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        header img {
            height: 60px;
            width: auto;
        }
        nav.menu a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: color 0.3s ease, text-decoration 0.3s ease;
        }
        nav.menu a:hover,
        nav.menu a:focus {
            text-decoration: underline;
            color: #aad4ff;
            outline: none;
        }
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        section {
            padding: 50px 20px;
            background-color: #f4f7fa;
            border-bottom: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 40px;
        }
        .section-title {
            font-size: 2rem;
            color: #002b55;
            margin-bottom: 25px;
            font-weight: 700;
        }
        footer {
            background-color: #002b55;
            color: white;
            text-align: center;
            padding: 40px 20px;
            font-size: 14px;
        }
        .footer-columns {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto 30px;
            text-align: left;
        }
        .footer-column {
            flex: 1 1 200px;
            margin: 10px;
        }
        .footer-column h4 {
            margin-bottom: 10px;
            color: #ffffff;
            font-weight: 600;
        }
        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-column ul li {
            margin-bottom: 8px;
        }
        .footer-column ul li a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer-column ul li a:hover,
        .footer-column ul li a:focus {
            text-decoration: underline;
            color: #aad4ff;
            outline: none;
        }
        ul li a {
            color: #002b55;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        ul li a:hover,
        ul li a:focus {
            text-decoration: underline;
            color: #004080;
            outline: none;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            max-width: 400px;
            box-sizing: border-box;
        }
        form label {
            display: block;
            margin-bottom: 5px;
            color: #002b55;
            font-weight: 600;
        }
        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            font-family: inherit;
            box-sizing: border-box;
        }
        form input[type="submit"] {
            background-color: #002b55;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }
        form input[type="submit"]:hover,
        form input[type="submit"]:focus {
            background-color: #004080;
            outline: none;
        }
        .profile-card {
            display: flex;
            gap: 30px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            align-items: flex-start;
            flex-wrap: wrap;
        }
        .profile-card img {
            border-radius: 10px;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            object-fit: cover;
        }
        .profile-description {
            flex: 1;
            min-width: 280px;
        }
        .profile-description h2 {
            color: #002b55;
            margin-top: 0;
            font-weight: 700;
        }
        .profile-description p, .profile-description ul {
            font-size: 16px;
            line-height: 1.6;
            margin-top: 0;
        }
        /* Responsive */
        @media (max-width: 700px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }
            nav.menu {
                margin-top: 15px;
                width: 100%;
            }
            nav.menu a {
                display: inline-block;
                margin: 10px 10px 0 0;
            }
            .profile-card {
                flex-direction: column;
                align-items: center;
            }
            .profile-card img {
                width: 100%;
                max-width: 300px;
            }
            main {
                padding: 20px 15px;
            }
            section {
                padding: 30px 15px;
            }
        }
    </style>
</head>
<body>
    <header>
        <img src="logo.jpg" alt="Logo du Cabinet Avocat Droit Étranger" />
        <nav class="menu" aria-label="Menu principal">
            <a href="#accueil">Accueil</a>
            <a href="rdv-pref.php">RDV Préfecture</a>
            <a href="rdv-avocat.php">Prendre RDV Avocat</a>
            <a href="#droits">Droits des étrangers</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>

    <main>
        <section id="accueil" tabindex="-1">
            <h1 class="section-title">Bienvenue au Cabinet</h1>
            <div class="profile-card">
                <img src="sirine.jpg" alt="Photo de Maître Mzabi" />
                <div class="profile-description">
                    <h2>Maître Mzabi</h2>
                    <p>
                        Vous êtes confronté à des questions juridiques impliquant des lois étrangères ?
                        Je suis <strong>Maître Mzabi</strong>, avocat au Barreau de Sébastopol, Paris. Je me consacre à vous offrir une expertise pointue en droit étranger.
                    </p>
                    <p>
                        Le droit international et les législations étrangères peuvent être complexes. Mon rôle est de vous guider à travers ces défis, en vous fournissant un accompagnement juridique clair, stratégique et adapté à vos besoins.
                    </p>
                    <h3>Expertise :</h3>
                    <ul>
                        <li><strong>Immigration et expatriation :</strong> Visas, titres de séjour, naturalisation.</li>
                        <li><strong>Affaires internationales :</strong> Contrats, implantation à l'étranger, litiges.</li>
                        <li><strong>Famille internationale :</strong> Mariages, divorces, successions entre nationalités.</li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="droits" tabindex="-1">
            <h2 class="section-title">Droits des étrangers</h2>
            <ul>
                <li><a href="droits/oqtf.php">Contester une OQTF</a></li>
                <li><a href="droits/nationalite.php">Demander la nationalité</a></li>
                <li><a href="droits/sejour.php">Titre de séjour</a></li>
                <li><a href="droits/regroupement.php">Regroupement familial</a></li>
            </ul>
        </section>

        <section id="contact" tabindex="-1">
            <h2 class="section-title">Contact</h2>
            <p><strong>Téléphone :</strong> 01 23 45 67 89</p>
            <p><strong>Email :</strong> <a href="mailto:contact@cabinet-avocat.fr">contact@cabinet-avocat.fr</a></p>
            <p><strong>Adresse :</strong> 123 rue de la Loi, Paris</p>
        </section>
    </main>

    <footer>
        &copy; 2025 Cabinet d'avocat - Tous droits réservés.
    </footer>
</body>
</html>






