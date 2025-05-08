<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ilinix Cloud Internship Program</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* ===== VARIABLES ===== */
    :root {
        --primary: #00c851;
        --primary-dark: #00a040;
        --primary-light: #7dffb3;
        --primary-transparent: rgba(0, 200, 81, 0.1);
        --secondary: #293241;
        --secondary-dark: #1c232e;
        --secondary-light: #3d4a61;
        --white: #ffffff;
        --off-white: #f9f9f9;
        --gray-light: #f5f5f5;
        --gray: #e0e0e0;
        --gray-dark: #9e9e9e;
        --text-dark: #333333;
        --text-light: #777777;
        --shadow-sm: 0 2px 5px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 5px 15px rgba(0, 0, 0, 0.07);
        --shadow-lg: 0 15px 30px rgba(0, 0, 0, 0.1);
        --shadow-highlight: 0 5px 25px rgba(0, 200, 81, 0.3);
        --transition-fast: 0.1s ease;
        --transition: 0.1s ease;
        --transition-slow: 0.1s ease;
        --cubic-bezier: cubic-bezier(0.25, 0.1, 0.25, 1);
    }

    /* ===== GLOBAL STYLES ===== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    html {
        scroll-behavior: smooth;
        overflow-x: hidden;
    }

    body {
        background-color: var(--off-white);
        color: var(--text-dark);
        line-height: 1.6;
        font-size: 16px;
        overflow-x: hidden;
        position: relative;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        position: relative;
        z-index: 1;
    }

    section {
        position: relative;
        padding: 100px 0;
        overflow: hidden;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 20px;
    }

    p {
        margin-bottom: 20px;
        color: var(--text-light);
    }

    a {
        text-decoration: none;
        color: var(--primary);
        transition: var(--transition);
    }

    a:hover {
        color: var(--primary-dark);
    }

    ul,
    ol {
        list-style: none;
    }

    img {
        max-width: 100%;
        height: auto;
    }

    .highlight {
        color: var(--primary);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 25px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: none;
        outline: none;
        text-align: center;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn i {
        margin-left: 8px;
        font-size: 14px;
        transition: transform 0.3s ease;
    }

    .btn:hover i {
        transform: translateX(4px);
    }

    .btn-primary {
        background-color: var(--primary);
        color: var(--white);
        box-shadow: 0 4px 15px rgba(0, 200, 81, 0.4);
    }

    .btn-primary:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: var(--transition);
        z-index: -1;
    }

    .btn-primary:hover {
        box-shadow: 0 7px 20px rgba(0, 200, 81, 0.6);
        transform: translateY(-2px);
    }

    .btn-primary:hover:before {
        left: 100%;
    }

    .btn-secondary {
        background-color: transparent;
        color: var(--text-dark);
        border: 2px solid var(--gray);
    }

    .btn-secondary:hover {
        background-color: var(--gray-light);
        border-color: var(--gray-dark);
    }

    .btn-login,
    .btn-logout {
        color: var(--text-dark);
        background: transparent;
        padding: 10px 20px;
    }

    .btn-login:hover,
    .btn-logout:hover {
        color: var(--primary);
    }

    .btn-signup,
    .btn-dashboard {
        background-color: var(--primary);
        color: var(--white);
        padding: 10px 20px;
        box-shadow: 0 4px 10px rgba(0, 200, 81, 0.3);
    }

    .btn-signup:hover,
    .btn-dashboard:hover {
        background-color: var(--primary-dark);
        color: var(--white);
        box-shadow: 0 6px 15px rgba(0, 200, 81, 0.4);
        transform: translateY(-2px);
    }

    .btn-logout {
        display: none;
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .section-tag {
        display: inline-block;
        padding: 5px 15px;
        background-color: var(--primary-transparent);
        color: var(--primary-dark);
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .section-header h2 {
        font-size: 36px;
        margin-bottom: 15px;
        position: relative;
    }

    .section-header h2:after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background-color: var(--primary);
        margin: 15px auto 0;
    }

    .section-header p {
        font-size: 18px;
        color: var(--text-light);
    }

    .section-pattern {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(var(--primary-transparent) 2px, transparent 2px);
        background-size: 30px 30px;
        opacity: 0.3;
        pointer-events: none;
    }

    /* ===== CUSTOM CURSOR ===== */
    .cursor-dot,
    .cursor-outline {
        pointer-events: none;
        position: fixed;
        top: 0;
        left: 0;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        z-index: 9999;
        transition: transform 0.1s;
    }

    .cursor-dot {
        width: 8px;
        height: 8px;
        background-color: var(--primary);
    }

    .cursor-outline {
        width: 40px;
        height: 40px;
        border: 2px solid var(--primary);
        transition: all 0.2s ease-out;
    }

    /* ===== PARTICLES BACKGROUND ===== */
    #particles-js {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 0;
        pointer-events: none;
    }

    /* ===== HEADER ===== */
    header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        background-color: rgba(255, 255, 255, 0.95);
        box-shadow: var(--shadow-sm);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    header.scrolled {
        box-shadow: var(--shadow-md);
        background-color: rgba(255, 255, 255, 0.98);
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
    }

    .logo {
        display: flex;
        align-items: center;
        text-decoration: none;
        font-size: 28px;
        font-weight: 800;
        position: relative;
    }

    .logo-text {
        color: var(--secondary);
        position: relative;
        z-index: 1;
    }

    .logo-text .highlight {
        color: var(--primary);
    }

    .logo-dot {
        position: absolute;
        width: 8px;
        height: 8px;
        background-color: var(--primary);
        border-radius: 50%;
        top: 0;
        right: -12px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.5);
            opacity: 0.7;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .nav-links {
        display: flex;
        align-items: center;
    }

    .nav-link {
        margin: 0 15px;
        color: var(--text-dark);
        font-weight: 600;
        position: relative;
        padding: 5px 0;
    }

    .nav-link:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0;
        height: 2px;
        background-color: var(--primary);
        transition: width 0.3s ease;
    }

    .nav-link:hover,
    .nav-link.active {
        color: var(--primary);
    }

    .nav-link:hover:after,
    .nav-link.active:after {
        width: 100%;
    }

    .hamburger-menu {
        display: none;
        flex-direction: column;
        justify-content: space-between;
        width: 30px;
        height: 20px;
        cursor: pointer;
        z-index: 1001;
        margin-left: auto;
        /* Align to the right */
    }

    .hamburger-menu .bar {
        width: 100%;
        height: 3px;
        background-color: var(--text-dark);
        border-radius: 3px;
        transition: var(--transition);
    }

    /* ===== RESPONSIVE STYLES ===== */
    @media (max-width: 768px) {
        .navbar {
            position: relative;
        }

        .hamburger-menu {
            display: flex;
            margin-left: auto;
            /* Push to the right */
        }

        .auth-buttons {
            display: none;
            /* Hide desktop auth buttons on mobile */
        }

        .nav-links {
            position: fixed;
            top: 80px;
            left: 0;
            width: 100%;
            background-color: var(--white);
            box-shadow: var(--shadow-md);
            padding: 20px;
            flex-direction: column;
            gap: 15px;
            transform: translateY(-200%);
            transition: transform 0.5s ease;
            z-index: 999;
        }

        .nav-links.show {
            transform: translateY(0);
        }

        /* Mobile auth buttons styling - include these within the mobile menu */
        .nav-links .btn-login,
        .nav-links .btn-signup,
        .nav-links .btn-dashboard,
        .nav-links .btn-logout {
            margin-top: 15px;
            width: 100%;
            text-align: center;
            padding: 12px 20px;
        }

        .nav-links .btn-dashboard,
        .nav-links .btn-signup {
            background-color: var(--primary);
            color: var(--white);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 200, 81, 0.3);
        }

        .nav-links .btn-login,
        .nav-links .btn-logout {
            color: var(--text-dark);
            background: transparent;
        }
    }

    /* ===== HERO SECTION ===== */
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding-top: 100px;
        background: linear-gradient(to bottom right, var(--white) 0%, var(--off-white) 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none;
    }

    .shape {
        position: absolute;
        opacity: 0.1;
        animation: float 6s infinite ease-in-out;
    }

    .shape-circle {
        width: 150px;
        height: 150px;
        background-color: var(--primary);
        border-radius: 50%;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .shape-square {
        width: 100px;
        height: 100px;
        background-color: var(--secondary);
        top: 60%;
        right: 10%;
        transform: rotate(45deg);
        animation-delay: 1s;
    }

    .shape-triangle {
        width: 0;
        height: 0;
        border-left: 60px solid transparent;
        border-right: 60px solid transparent;
        border-bottom: 120px solid var(--primary-dark);
        top: 20%;
        right: 20%;
        animation-delay: 2s;
    }

    .shape-plus {
        font-size: 80px;
        color: var(--primary-light);
        bottom: 20%;
        left: 15%;
        animation-delay: 3s;
    }

    .shape-squiggle {
        width: 100px;
        height: 60px;
        background: var(--secondary-light);
        border-radius: 50px;
        bottom: 40%;
        right: 25%;
        animation-delay: 4s;
    }

    @keyframes float {
        0% {
            transform: translateY(0px) rotate(0deg);
        }

        50% {
            transform: translateY(-20px) rotate(5deg);
        }

        100% {
            transform: translateY(0px) rotate(0deg);
        }
    }

    .hero-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .hero-text {
        flex: 1;
        padding-right: 50px;
    }

    .animated-title {
        font-size: 48px;
        line-height: 1.2;
        margin-bottom: 25px;
        overflow: hidden;
    }

    .animated-title .animated-text {
        display: block;
        animation: revealText 1s var(--cubic-bezier) forwards;
        opacity: 0;
        transform: translateY(100%);
    }

    .animated-title .highlight {
        display: block;
        animation: revealText 1s var(--cubic-bezier) 0.3s forwards;
        opacity: 0;
        transform: translateY(100%);
    }

    @keyframes revealText {
        0% {
            opacity: 0;
            transform: translateY(100%);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-text p {
        font-size: 18px;
        margin-bottom: 30px;
        animation: fadeIn 1s ease 0.6s forwards;
        opacity: 0;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .cta-buttons {
        display: flex;
        gap: 20px;
        margin-bottom: 40px;
        animation: fadeIn 1s ease 0.8s forwards;
        opacity: 0;
    }

    .hero-stats {
        display: flex;
        gap: 40px;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        opacity: 0;
    }

    .stat-number {
        font-size: 36px;
        font-weight: 700;
        color: var(--primary);
    }

    .stat-label {
        font-size: 14px;
        color: var(--text-light);
    }

    .hero-visual {
        flex: 1;
        position: relative;
        height: 500px;
        perspective: 1000px;
    }

    .hero-cube {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotateX(-30deg) rotateY(45deg);
        width: 250px;
        height: 250px;
        transform-style: preserve-3d;
        animation: rotateCube 20s linear infinite;
    }

    .cube-face {
        position: absolute;
        width: 100%;
        height: 100%;
        border: 2px solid var(--primary);
        background-color: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        box-shadow: 0 0 20px rgba(0, 200, 81, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cube-face.front {
        transform: translateZ(125px);
        background-image: url('/api/placeholder/250/250');
        background-size: cover;
        background-position: center;
    }

    .cube-face.back {
        transform: rotateY(180deg) translateZ(125px);
        background-color: rgba(41, 50, 65, 0.05);
    }

    .cube-face.right {
        transform: rotateY(90deg) translateZ(125px);
        background-color: rgba(0, 200, 81, 0.05);
    }

    .cube-face.left {
        transform: rotateY(-90deg) translateZ(125px);
        background-color: rgba(41, 50, 65, 0.05);
    }

    .cube-face.top {
        transform: rotateX(90deg) translateZ(125px);
        background-color: rgba(0, 200, 81, 0.05);
    }

    .cube-face.bottom {
        transform: rotateX(-90deg) translateZ(125px);
        background-color: rgba(41, 50, 65, 0.05);
    }

    @keyframes rotateCube {
        0% {
            transform: translate(-50%, -50%) rotateX(-30deg) rotateY(0deg);
        }

        100% {
            transform: translate(-50%, -50%) rotateX(-30deg) rotateY(360deg);
        }
    }

    .floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .float-element {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: var(--white);
        box-shadow: var(--shadow-md);
        animation: floatElement 6s infinite ease-in-out;
    }

    .float-element i {
        font-size: 24px;
        color: var(--primary);
    }

    .element-1 {
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    @media (max-width: 968px) {
        .element-1 {
            top: auto;
            bottom: 20%;
        }
    }

    .element-2 {
        top: 70%;
        left: 20%;
        animation-delay: 1.5s;
    }

    .element-3 {
        top: 30%;
        right: 15%;
        animation-delay: 1s;
    }

    .element-4 {
        bottom: 20%;
        right: 25%;
        animation-delay: 2.5s;
    }

    @keyframes floatElement {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    .scroll-indicator {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        animation: fadeIn 1s ease 1.5s forwards;
        opacity: 0;
    }

    .scroll-indicator span {
        font-size: 14px;
        color: var(--text-light);
        margin-bottom: 10px;
    }

    .mouse {
        width: 26px;
        height: 40px;
        border: 2px solid var(--text-light);
        border-radius: 20px;
        position: relative;
    }

    .wheel {
        position: absolute;
        width: 4px;
        height: 8px;
        background-color: var(--primary);
        left: 50%;
        top: 6px;
        transform: translateX(-50%);
        border-radius: 2px;
        animation: scrollWheel 2s infinite;
    }

    @keyframes scrollWheel {
        0% {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        100% {
            opacity: 0;
            transform: translateX(-50%) translateY(15px);
        }
    }

    /* ===== FEATURES SECTION ===== */
    .features {
        background-color: var(--white);
        position: relative;
        z-index: 1;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
    }

    .feature-card {
        height: 280px;
        perspective: 1000px;
    }

    .card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.8s;
        transform-style: preserve-3d;
    }

    .feature-card:hover .card-inner {
        transform: rotateY(180deg);
    }

    .card-front,
    .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 15px;
        padding: 30px;
    }

    .card-front {
        background-color: var(--white);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-md);
        transform: rotateY(0deg);
    }

    .card-back {
        background-color: var(--primary);
        color: var(--white);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transform: rotateY(180deg);
        box-shadow: var(--shadow-md);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        background-color: var(--primary-transparent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        transition: var(--transition);
    }

    .feature-icon i {
        font-size: 36px;
        color: var(--primary);
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1);
    }

    .card-front h3 {
        font-size: 20px;
        margin-bottom: 0;
    }

    .card-back p {
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 20px;
    }

    .card-link {
        color: var(--white);
        display: flex;
        align-items: center;
        font-weight: 600;
    }

    .card-link i {
        margin-left: 5px;
        transition: transform 0.3s ease;
    }

    .card-link:hover i {
        transform: translateX(5px);
    }

    /* ===== PROGRAM OVERVIEW ===== */
    .program-overview {
        position: relative;
        background-color: var(--off-white);
    }

    .parallax-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('/api/placeholder/1600/900');
        background-position: center;
        background-size: cover;
        background-attachment: fixed;
        opacity: 0.05;
    }

    .timeline-container {
        max-width: 800px;
        margin: 50px auto;
        position: relative;
    }

    .timeline {
        position: relative;
        padding: 40px 0;
    }

    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        width: 2px;
        height: 100%;
        background-color: var(--gray);
        transform: translateX(-50%);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 60px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        top: 20px;
        left: 50%;
        width: 20px;
        height: 20px;
        background-color: var(--primary);
        border-radius: 50%;
        transform: translateX(-50%);
        z-index: 1;
        box-shadow: 0 0 0 5px var(--primary-transparent);
    }

    .timeline-content {
        position: relative;
        width: calc(50% - 40px);
        padding: 20px;
        background-color: var(--white);
        border-radius: 10px;
        box-shadow: var(--shadow-md);
    }

    .timeline-item:nth-child(odd) .timeline-content {
        margin-left: auto;
    }

    .timeline-item:nth-child(even) .timeline-content {
        margin-right: auto;
    }

    .timeline-content h3 {
        font-size: 20px;
        margin-bottom: 10px;
        color: var(--primary);
    }

    .timeline-content p {
        margin-bottom: 0;
    }

    .timeline-icon {
        position: absolute;
        top: 15px;
        width: 40px;
        height: 40px;
        background-color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
    }

    .timeline-item:nth-child(odd) .timeline-icon {
        left: -20px;
    }

    .timeline-item:nth-child(even) .timeline-icon {
        right: -20px;
    }

    .timeline-icon i {
        font-size: 18px;
        color: var(--primary);
    }

    .program-features {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin: 50px 0;
    }

    .program-feature {
        display: flex;
        align-items: center;
        background-color: var(--white);
        padding: 15px;
        border-radius: 8px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .program-feature:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .program-feature i {
        font-size: 20px;
        color: var(--primary);
        margin-right: 15px;
        flex-shrink: 0;
    }

    .program-feature p {
        margin-bottom: 0;
        font-size: 15px;
    }

    .program-cta {
        text-align: center;
        margin-top: 40px;
    }

    /* ===== TESTIMONIALS ===== */
    .testimonials {
        background-color: var(--white);
        position: relative;
    }

    .testimonial-slider {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
    }

    .testimonial-track {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .testimonial-card {
        flex: 0 0 100%;
        padding: 30px;
        background-color: var(--off-white);
        border-radius: 15px;
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .testimonial-image {
        flex-shrink: 0;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        border: 5px solid var(--white);
        box-shadow: var(--shadow-sm);
    }

    .testimonial-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .testimonial-content {
        flex-grow: 1;
    }

    .testimonial-content p {
        font-style: italic;
        margin-bottom: 15px;
    }

    .testimonial-author h4 {
        font-size: 18px;
        margin-bottom: 5px;
        color: var(--secondary);
    }

    .testimonial-author span {
        font-size: 14px;
        color: var(--primary);
    }

    .testimonial-controls {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 30px;
    }

    .control-prev,
    .control-next {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background-color: var(--white);
        box-shadow: var(--shadow-sm);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 15px;
        transition: var(--transition);
    }

    border-radius: 50%;
    border: none;
    background-color: var(--white);
    box-shadow: var(--shadow-sm);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 15px;
    transition: var(--transition);
    }

    .control-prev:hover,
    .control-next:hover {
        background-color: var(--primary);
        color: var(--white);
        box-shadow: var(--shadow-highlight);
    }

    .testimonial-dots {
        display: flex;
        gap: 8px;
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: var(--gray);
        cursor: pointer;
        transition: var(--transition);
    }

    .dot.active,
    .dot:hover {
        background-color: var(--primary);
        transform: scale(1.2);
    }

    /* ===== APPLICATION FORM ===== */
    .application {
        background-color: var(--off-white);
        position: relative;
    }

    .form-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 40px;
        background-color: var(--white);
        border-radius: 15px;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .form-decoration {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }

    .floating-icon {
        position: absolute;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: var(--primary-transparent);
        color: var(--primary);
        font-size: 20px;
        animation: floatIcon 8s infinite ease-in-out;
    }

    .icon-1 {
        top: 20px;
        right: 20px;
        animation-delay: 0s;
    }

    .icon-2 {
        bottom: 30px;
        right: 60px;
        animation-delay: 2s;
    }

    .icon-3 {
        top: 60px;
        left: 30px;
        animation-delay: 1s;
    }

    .icon-4 {
        bottom: 40px;
        left: 40px;
        animation-delay: 3s;
    }

    @keyframes floatIcon {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-15px) rotate(10deg);
        }
    }

    .form-group {
        margin-bottom: 25px;
        position: relative;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
        color: var(--text-dark);
    }

    .form-control {
        width: 100%;
        padding: 15px;
        border: 1px solid var(--gray);
        border-radius: 8px;
        background-color: var(--white);
        font-size: 16px;
        transition: all 0.3s ease;
        position: relative;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-transparent);
    }

    .focus-border {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background-color: var(--primary);
        transition: width 0.3s ease;
    }

    .form-control:focus~.focus-border {
        width: 100%;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .file-upload {
        display: block;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .file-upload input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 10;
    }

    .file-custom {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        background-color: var(--gray-light);
        border: 1px dashed var(--gray-dark);
        border-radius: 8px;
        transition: var(--transition);
    }

    .file-custom i {
        margin-right: 10px;
        font-size: 20px;
        color: var(--primary);
    }

    .file-upload:hover .file-custom {
        background-color: var(--primary-transparent);
        border-color: var(--primary);
    }

    .btn-submit {
        width: 100%;
        padding: 15px;
        font-size: 18px;
        font-weight: 600;
        background-color: var(--primary);
        color: var(--white);
        border: none;
        border-radius: 8px;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: var(--transition);
        z-index: 1;
        margin-top: 20px;
    }

    .btn-submit:hover {
        background-color: var(--primary-dark);
        box-shadow: var(--shadow-highlight);
        transform: translateY(-2px);
    }

    .btn-border {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        fill: none;
        stroke: var(--primary);
        stroke-width: 2;
        stroke-dasharray: 480;
        stroke-dashoffset: 480;
        transition: stroke-dashoffset 0.6s cubic-bezier(0.25, 0.1, 0.25, 1);
        z-index: -1;
    }

    .btn-submit:hover .btn-border {
        stroke-dashoffset: 0;
    }

    /* ===== FOOTER ===== */
    footer {
        background-color: var(--secondary);
        color: var(--white);
        position: relative;
        padding: 80px 0 20px;
    }

    .footer-wave {
        position: absolute;
        top: -100px;
        left: 0;
        width: 100%;
        height: 100px;
        overflow: hidden;
    }

    .footer-wave svg {
        width: 100%;
        height: 100%;
        fill: var(--secondary);
    }

    .footer-content {
        display: grid;
        grid-template-columns: 1.5fr repeat(3, 1fr);
        gap: 40px;
        margin-bottom: 50px;
    }

    .footer-brand {
        padding-right: 20px;
    }

    .footer-logo {
        font-size: 28px;
        font-weight: 800;
        color: var(--white);
        margin-bottom: 20px;
        display: inline-block;
    }

    .footer-logo span {
        color: var(--primary);
    }

    .footer-brand p {
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 25px;
    }

    .social-links {
        display: flex;
        gap: 15px;
    }

    .social-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        transition: var(--transition);
    }

    .social-link:hover {
        background-color: var(--primary);
        color: var(--white);
        transform: translateY(-3px);
    }

    .footer-links h3 {
        font-size: 18px;
        margin-bottom: 25px;
        color: var(--white);
        position: relative;
        padding-bottom: 10px;
    }

    .footer-links h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background-color: var(--primary);
    }

    .footer-links ul {
        list-style: none;
    }

    .footer-links li {
        margin-bottom: 12px;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.7);
        transition: var(--transition);
        position: relative;
        padding-left: 15px;
    }

    .footer-links a:before {
        content: '›';
        position: absolute;
        left: 0;
        transition: transform 0.3s ease;
    }

    .footer-links a:hover {
        color: var(--primary);
        padding-left: 20px;
    }

    .footer-links a:hover:before {
        transform: translateX(5px);
    }

    .footer-newsletter h3 {
        font-size: 18px;
        margin-bottom: 20px;
        color: var(--white);
    }

    .footer-newsletter p {
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 20px;
    }

    .newsletter-form {
        display: flex;
        height: 50px;
        position: relative;
    }

    .newsletter-form input {
        flex-grow: 1;
        padding: 0 20px;
        border: none;
        border-radius: 25px;
        background-color: rgba(255, 255, 255, 0.1);
        color: var(--white);
        font-size: 16px;
    }

    .newsletter-form input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .newsletter-form input:focus {
        outline: none;
        background-color: rgba(255, 255, 255, 0.2);
    }

    .newsletter-form button {
        position: absolute;
        right: 5px;
        top: 5px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--primary);
        color: var(--white);
        border: none;
        cursor: pointer;
        transition: var(--transition);
    }

    .newsletter-form button:hover {
        background-color: var(--primary-dark);
        transform: scale(1.05);
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
    }

    .footer-bottom p {
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 0;
    }

    .footer-bottom-links {
        display: flex;
        gap: 20px;
    }

    .footer-bottom-links a {
        color: rgba(255, 255, 255, 0.6);
        transition: var(--transition);
    }

    .footer-bottom-links a:hover {
        color: var(--primary);
    }

    /* ===== MODAL ===== */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2000;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal.show .modal-overlay {
        opacity: 1;
    }

    .modal-container {
        width: 100%;
        max-width: 500px;
        perspective: 1000px;
    }

    .modal-content {
        background-color: var(--white);
        border-radius: 15px;
        padding: 40px;
        box-shadow: var(--shadow-lg);
        transform: translateY(50px) rotateX(-10deg);
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.25, 0.1, 0.25, 1.5);
        position: relative;
    }

    .modal.show .modal-content {
        transform: translateY(0) rotateX(0);
        opacity: 1;
    }

    .close-modal {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: var(--gray-light);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        z-index: 1;
    }

    .close-modal:hover {
        background-color: var(--primary-transparent);
        transform: rotate(90deg);
    }

    .close-modal i {
        font-size: 16px;
        color: var(--text-dark);
    }

    .modal-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .modal-logo {
        font-size: 24px;
        font-weight: 800;
        color: var(--secondary);
        margin-bottom: 15px;
    }

    .modal-logo span {
        color: var(--primary);
    }

    .modal-header h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .modal-header p {
        color: var(--text-light);
        margin-bottom: 0;
    }

    .auth-form .form-group {
        margin-bottom: 20px;
    }

    .input-icon-wrapper {
        position: relative;
    }

    .input-icon-wrapper i {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: var(--text-light);
    }

    .input-icon-wrapper .form-control {
        padding-left: 45px;
    }

    .password-toggle {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-light);
        cursor: pointer;
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .checkbox-container {
        position: relative;
        padding-left: 30px;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: var(--gray-light);
        border-radius: 4px;
        transition: var(--transition);
    }

    .checkbox-container:hover .checkmark {
        background-color: var(--gray);
    }

    .checkbox-container input:checked~.checkmark {
        background-color: var(--primary);
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .checkbox-container input:checked~.checkmark:after {
        display: block;
    }

    .checkbox-container .checkmark:after {
        left: 7px;
        top: 3px;
        width: 6px;
        height: 12px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .forgot-password {
        color: var(--primary);
        font-weight: 600;
    }

    .forgot-password:hover {
        text-decoration: underline;
    }

    .btn-auth {
        width: 100%;
        padding: 15px;
        background-color: var(--primary);
        color: var(--white);
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn-auth:hover {
        background-color: var(--primary-dark);
        color: var(--white);
    }

    .btn-auth:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: var(--transition);
        z-index: -1;
    }

    .btn-auth:hover:before {
        left: 100%;
    }

    .form-separator {
        position: relative;
        text-align: center;
        margin: 20px 0;
    }

    .form-separator:before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 1px;
        background-color: var(--gray);
    }

    .form-separator span {
        position: relative;
        background-color: var(--white);
        padding: 0 15px;
        color: var(--text-light);
        font-size: 14px;
    }

    .social-auth {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 20px;
    }

    .btn-social {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
        border-radius: 8px;
        background-color: var(--gray-light);
        border: 1px solid var(--gray);
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-social:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-social i {
        margin-right: 10px;
        font-size: 18px;
    }

    .btn-social.google i {
        color: #DB4437;
    }

    .btn-social.github i {
        color: #333;
    }

    .form-terms {
        margin: 15px 0;
    }

    .form-terms a {
        color: var(--primary);
        font-weight: 600;
    }

    .form-terms a:hover {
        text-decoration: underline;
    }

    .form-footer {
        text-align: center;
        margin-top: 20px;
        color: var(--text-light);
        font-size: 14px;
    }

    .form-footer a {
        color: var(--primary);
        font-weight: 600;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }

    /* ===== RESPONSIVE STYLES ===== */
    @media (max-width: 1200px) {
        .hero-text {
            padding-right: 20px;
        }

        .animated-title {
            font-size: 40px;
        }

        .footer-content {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        section {
            padding: 80px 0;
        }

        .hero-content {
            flex-direction: column;
            text-align: center;
        }

        .hero-text {
            padding-right: 0;
            margin-bottom: 50px;
        }

        .hero-stats {
            justify-content: center;
        }

        .cta-buttons {
            justify-content: center;
        }

        .hero-visual {
            height: 400px;
        }

        .timeline:before {
            left: 40px;
        }

        .timeline-dot {
            left: 40px;
        }

        .timeline-content {
            width: calc(100% - 80px);
            margin-left: 80px !important;
        }

        .timeline-item:nth-child(odd) .timeline-icon,
        .timeline-item:nth-child(even) .timeline-icon {
            left: 20px;
        }

        .testimonial-card {
            flex-direction: column;
            text-align: center;
        }

        .testimonial-image {
            margin-bottom: 20px;
        }
    }

    @media (max-width: 768px) {
        .hamburger-menu {
            display: flex;
        }

        .nav-links {
            position: fixed;
            top: 80px;
            left: 0;
            width: 100%;
            background-color: var(--white);
            box-shadow: var(--shadow-md);
            padding: 20px;
            flex-direction: column;
            gap: 15px;
            transform: translateY(-200%);
            transition: transform 0.5s ease;
            z-index: 999;
        }

        .nav-links.show {
            transform: translateY(0);
        }

        .animated-title {
            font-size: 36px;
        }

        .hero-text p {
            font-size: 16px;
        }

        .section-header h2 {
            font-size: 30px;
        }

        .features-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .footer-content {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .footer-bottom {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .animated-title {
            font-size: 30px;
        }

        .cta-buttons {
            flex-direction: column;
            gap: 15px;
        }

        .hero-stats {
            flex-direction: column;
            gap: 20px;
        }

        .stat-item {
            align-items: center;
        }

        .footer-bottom-links {
            flex-direction: column;
            gap: 10px;
        }

        .modal-content {
            padding: 30px 20px;
        }
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes zoomIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-20px);
        }

        60% {
            transform: translateY(-10px);
        }
    }

    /* AOS Default Animations */
    [data-aos="custom-fade-up"] {
        opacity: 0;
        transform: translateY(30px);
        transition-property: opacity, transform;
    }

    [data-aos="custom-fade-up"].aos-animate {
        opacity: 1;
        transform: translateY(0);
    }

    /* Custom Animation Classes */
    .fade-in {
        animation: fadeIn 1s ease forwards;
    }

    .fade-in-up {
        animation: fadeInUp 1s ease forwards;
    }

    .fade-in-left {
        animation: fadeInLeft 1s ease forwards;
    }

    .fade-in-right {
        animation: fadeInRight 1s ease forwards;
    }

    .zoom-in {
        animation: zoomIn 1s ease forwards;
    }

    .bounce {
        animation: bounce 2s infinite;
    }
</style>

<body>
    <!-- Cursor Animation -->
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <!-- Particles Background -->
    <div id="particles-js"></div>

    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="#" class="logo">
                    <span class="logo-text">i<span class="highlight">linix</span></span>
                    <span class="logo-dot"></span>
                </a>

                <ul class="nav-links">
                    <li><a href="#" class="nav-link active">Home</a></li>
                    <li><a href="#program" class="nav-link">Program</a></li>
                    <li><a href="#features" class="nav-link">Benefits</a></li>
                    <li><a href="#apply" class="nav-link">Apply</a></li>

                    <!-- Mobile auth buttons (these will only display in mobile view) -->
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-login" id="loginBtn">Log in</a>
                        <a href="{{ route('register') }}" class="btn btn-signup" id="signupBtn">Sign up</a>
                    @endguest

                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-dashboard" id="dashboardBtn">Dashboard</a>
                        <a href="{{ route('logout') }}" class="btn btn-logout" id="logoutBtn"
                            onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">Log
                            out</a>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endauth
                </ul>


                <!-- Hamburger menu moved to the end -->
                <div class="hamburger-menu">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-shapes">
            <div class="shape shape-circle"></div>
            <div class="shape shape-square"></div>
            <div class="shape shape-triangle"></div>
            <div class="shape shape-plus"></div>
            <div class="shape shape-squiggle"></div>
        </div>

        <div class="container">
            <div class="hero-content">
                <div class="hero-text" data-aos="fade-right" data-aos-delay="200">
                    <h1 class="animated-title">
                        <span class="animated-text">Launch Your Career in</span>
                        <span class="highlight">Cloud Technology</span>
                    </h1>
                    <p>Join ilinix's internship program and gain real-world experience in modern cloud contact center
                        solutions, AI technologies, and customer experience design.</p>
                    <div class="cta-buttons">
                        <a href="#apply" class="btn btn-primary btn-apply">
                            <span>Apply Now</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#program" class="btn btn-secondary btn-learn">
                            <span>Learn More</span>
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                            <span class="stat-number">12</span>
                            <span class="stat-label">Week Program</span>
                        </div>
                        <div class="stat-item" data-aos="fade-up" data-aos-delay="400">
                            <span class="stat-number">3</span>
                            <span class="stat-label">Focus Areas</span>
                        </div>
                        <div class="stat-item" data-aos="fade-up" data-aos-delay="500">
                            <span class="stat-number">165+</span>
                            <span class="stat-label">Countries</span>
                        </div>
                    </div>
                </div>

                <div class="hero-visual" data-aos="fade-left" data-aos-delay="300">
                    <div class="hero-cube">
                        <div class="cube-face front"></div>
                        <div class="cube-face back"></div>
                        <div class="cube-face right"></div>
                        <div class="cube-face left"></div>
                        <div class="cube-face top"></div>
                        <div class="cube-face bottom"></div>
                    </div>
                    <div class="floating-elements">
                        <div class="float-element element-1">
                            <i class="fas fa-cloud"></i>
                        </div>
                        <div class="float-element element-2">
                            <i class="fa-brands fa-google"></i>
                        </div>
                        <div class="float-element element-3">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="float-element element-4">
                            <i class="fa-brands fa-aws"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="scroll-indicator">
            <span>Scroll Down</span>
            <div class="mouse">
                <div class="wheel"></div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="section-pattern"></div>

        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-tag">Why Choose Us</span>
                <h2>Why Join Our Internship Program</h2>
                <p>Gain valuable skills and experience in a rapidly growing cloud technology company</p>
            </div>

            <div class="features-grid">
                <div class="feature-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card-inner">
                        <div class="card-front">
                            <div class="feature-icon">
                                <i class="fas fa-cloud"></i>
                            </div>
                            <h3>Cloud-First Experience</h3>
                        </div>
                        <div class="card-back">
                            <p>Work directly with modern cloud technologies and learn how to build scalable solutions
                                used by global businesses.</p>
                            <a href="#program" class="card-link">Learn More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="feature-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="card-inner">
                        <div class="card-front">
                            <div class="feature-icon">
                                <i class="fas fa-robot"></i>
                            </div>
                            <h3>AI & Machine Learning</h3>
                        </div>
                        <div class="card-back">
                            <p>Get hands-on experience with AI-enriched solutions and learn how machine learning
                                enhances customer experiences.</p>
                            <a href="#program" class="card-link">Learn More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="feature-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="card-inner">
                        <div class="card-front">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3>Mentorship Program</h3>
                        </div>
                        <div class="card-back">
                            <p>Work alongside industry experts who will guide your professional development and help you
                                grow your skills.</p>
                            <a href="#program" class="card-link">Learn More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="feature-card" data-aos="zoom-in" data-aos-delay="400">
                    <div class="card-inner">
                        <div class="card-front">
                            <div class="feature-icon">
                                <i class="fas fa-code"></i>
                            </div>
                            <h3>Real-World Projects</h3>
                        </div>
                        <div class="card-back">
                            <p>Contribute to actual projects that serve our global customer base across 165 countries.
                            </p>
                            <a href="#program" class="card-link">Learn More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="feature-card" data-aos="zoom-in" data-aos-delay="500">
                    <div class="card-inner">
                        <div class="card-front">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3>Career Growth</h3>
                        </div>
                        <div class="card-back">
                            <p>Top-performing interns may receive full-time job offers and continued career development
                                opportunities.</p>
                            <a href="#program" class="card-link">Learn More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="feature-card" data-aos="zoom-in" data-aos-delay="600">
                    <div class="card-inner">
                        <div class="card-front">
                            <div class="feature-icon">
                                <i class="fas fa-globe"></i>
                            </div>
                            <h3>Global Experience</h3>
                        </div>
                        <div class="card-back">
                            <p>Join a company that serves businesses across 165 countries and gain a global perspective
                                on technology solutions.</p>
                            <a href="#program" class="card-link">Learn More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="program-overview" id="program">
        <div class="parallax-bg"></div>

        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-tag">Program Details</span>
                <h2>Our Comprehensive Internship Program</h2>
                <p>Combining technical training, mentorship, and hands-on project experience</p>
            </div>

            <div class="timeline-container" data-aos="fade-up">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content" data-aos="fade-right">
                            <h3>Week 1-2: Onboarding</h3>
                            <p>Introduction to ilinix technologies, team building, and initial training.</p>
                            <div class="timeline-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content" data-aos="fade-left">
                            <h3>Week 3-5: Core Skills Development</h3>
                            <p>In-depth training in your chosen focus area and essential technologies.</p>
                            <div class="timeline-icon">
                                <i class="fas fa-code"></i>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content" data-aos="fade-right">
                            <h3>Week 6-10: Project Work</h3>
                            <p>Work on real client projects with guidance from your mentor and team.</p>
                            <div class="timeline-icon">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content" data-aos="fade-left">
                            <h3>Week 11-12: Presentation & Evaluation</h3>
                            <p>Present your work, receive feedback, and discuss future opportunities.</p>
                            <div class="timeline-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="program-features" data-aos="fade-up">
                <div class="program-feature">
                    <i class="fas fa-check-circle"></i>
                    <p>12-week intensive program with potential for extension</p>
                </div>
                <div class="program-feature">
                    <i class="fas fa-check-circle"></i>
                    <p>Focus areas: cloud infrastructure, AI development, customer experience design</p>
                </div>
                <div class="program-feature">
                    <i class="fas fa-check-circle"></i>
                    <p>Weekly training sessions and professional development workshops</p>
                </div>
                <div class="program-feature">
                    <i class="fas fa-check-circle"></i>
                    <p>One-on-one mentorship with experienced professionals</p>
                </div>
            </div>

            <div class="program-cta" data-aos="zoom-in">
                <a href="#apply" class="btn btn-primary">Apply Now</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-tag">Success Stories</span>
                <h2>Hear From Our Former Interns</h2>
                <p>What participants say about their experience in our internship program</p>
            </div>

            <div class="testimonial-slider" data-aos="fade-up">
                <div class="testimonial-track">
                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="/api/placeholder/100/100" alt="Former Intern">
                        </div>
                        <div class="testimonial-content">
                            <p>"The ilinix internship program was a transformative experience. I worked with
                                cutting-edge cloud technologies and received mentorship that accelerated my growth as a
                                developer."</p>
                            <div class="testimonial-author">
                                <h4>Sarah Johnson</h4>
                                <span>Cloud Engineer, Class of 2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="/api/placeholder/100/100" alt="Former Intern">
                        </div>
                        <div class="testimonial-content">
                            <p>"I joined ilinix as an intern and now I'm a full-time AI developer. The hands-on
                                experience with real projects gave me a competitive edge in the job market."</p>
                            <div class="testimonial-author">
                                <h4>Michael Chen</h4>
                                <span>AI Developer, Class of 2023</span>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="/api/placeholder/100/100" alt="Former Intern">
                        </div>
                        <div class="testimonial-content">
                            <p>"The global exposure and opportunity to work on solutions that impact businesses in 165+
                                countries was incredible. ilinix truly invests in their interns' growth."</p>
                            <div class="testimonial-author">
                                <h4>Olivia Rodriguez</h4>
                                <span>Product Manager, Class of 2024</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-controls">
                    <button class="control-prev"><i class="fas fa-chevron-left"></i></button>
                    <div class="testimonial-dots">
                        <span class="dot active"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>
                    <button class="control-next"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Form -->
    <section class="application" id="apply">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-tag">Join Us</span>
                <h2>Apply for the Internship Program</h2>
                <p>Submit your application today and take the first step toward a rewarding career in cloud technology
                </p>
            </div>

            <div class="form-container" data-aos="zoom-in">
                <div class="form-decoration">
                    <div class="floating-icon icon-1"><i class="fas fa-cloud"></i></div>
                    <div class="floating-icon icon-2"><i class="fas fa-code"></i></div>
                    <div class="floating-icon icon-3"><i class="fas fa-robot"></i></div>
                    <div class="floating-icon icon-4"><i class="fas fa-globe"></i></div>
                </div>

                <form id="applicationForm">
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" class="form-control" required>
                        <span class="focus-border"></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" class="form-control" required>
                        <span class="focus-border"></span>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" class="form-control">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group">
                            <label for="education">Current Education</label>
                            <input type="text" id="education" class="form-control" required>
                            <span class="focus-border"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="area">Area of Interest</label>
                        <select id="area" class="form-control" required>
                            <option value="">Select an option</option>
                            <option value="cloud">Cloud Infrastructure</option>
                            <option value="ai">AI & Machine Learning</option>
                            <option value="experience">Customer Experience Design</option>
                            <option value="development">Software Development</option>
                        </select>
                        <span class="focus-border"></span>
                    </div>

                    <div class="form-group">
                        <label for="message">Why are you interested in this program?</label>
                        <textarea id="message" rows="4" class="form-control" required></textarea>
                        <span class="focus-border"></span>
                    </div>

                    <div class="form-group">
                        <label class="file-upload">
                            <input type="file" id="resume" accept=".pdf,.doc,.docx">
                            <span class="file-custom">
                                <i class="fas fa-upload"></i>
                                <span class="file-text">Upload Resume (PDF, DOC)</span>
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-submit">
                        <span>Submit Application</span>
                        <svg class="btn-border" viewBox="0 0 180 60">
                            <polyline points="179,1 179,59 1,59 1,1 179,1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-wave">
            <svg viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path
                    d="M0,50 C150,20 350,0 500,15 C650,30 700,60 850,70 C1000,80 1100,60 1300,35 L1440,50 L1440,100 L0,100 Z">
                </path>
            </svg>
        </div>

        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <a href="#" class="footer-logo">i<span>linix</span></a>
                    <p>Creating AI-enriched customer experiences through the thoughtful application of design and
                        technology.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                    </div>
                </div>

                <div class="footer-links-container">
                    <div class="footer-links">
                        <h3>Company</h3>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Blog</a></li>
                        </ul>
                    </div>

                    <div class="footer-links">
                        <h3>Solutions</h3>
                        <ul>
                            <li><a href="#">Contact Center</a></li>
                            <li><a href="#">AI-Enriched Experiences</a></li>
                            <li><a href="#">Cloud Services</a></li>
                            <li><a href="#">Integrations</a></li>
                        </ul>
                    </div>

                    <div class="footer-links">
                        <h3>Internship</h3>
                        <ul>
                            <li><a href="#program">Program Details</a></li>
                            <li><a href="#features">Benefits</a></li>
                            <li><a href="#apply">Apply Now</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                </div>

                <div class="footer-newsletter">
                    <h3>Stay Updated</h3>
                    <p>Subscribe to our newsletter for the latest program updates.</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 ilinix. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookies Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <script>
        // Initialize AOS (Animate On Scroll)
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });

            // Initialize Particles.js for background effects
            initParticles();

            // Setup navigation behavior
            setupNavigation();

            // Setup custom cursor
            setupCustomCursor();

            // Setup form interactions
            setupFormInteractions();

            // Setup testimonial slider
            setupTestimonialSlider();

            // Setup authentication modals
            setupAuthModals();

            // Check login status
            checkLoginStatus();
        });

        function setupCustomCursor() {
            const cursor = document.querySelector('.cursor-dot');
            const cursorOutline = document.querySelector('.cursor-outline');

            if (!cursor || !cursorOutline) return; // element not found – just exit

            /* move with mouse */
            document.addEventListener('mousemove', e => {
                const {
                    clientX: x,
                    clientY: y
                } = e;
                const t = `translate3d(${x}px,${y}px,0)`;
                cursor.style.transform = t;
                cursorOutline.style.transform = t;
            }, {
                passive: true
            });

            /* interactive scaling on hover */
            const hovers = document.querySelectorAll(
                'a,button,.feature-card,.form-control,.checkbox-container'
            );

            hovers.forEach(el => {
                el.addEventListener('mouseenter', () => {
                    cursor.style.transform = 'translate(-50%,-50%) scale(1.5)';
                    cursorOutline.style.transform = 'translate(-50%,-50%) scale(1.5)';
                    cursorOutline.style.border = '1px solid var(--primary)';
                    cursorOutline.style.backgroundColor = 'rgba(0,200,81,0.1)';
                });
                el.addEventListener('mouseleave', () => {
                    cursor.style.transform = 'translate(-50%,-50%) scale(1)';
                    cursorOutline.style.transform = 'translate(-50%,-50%) scale(1)';
                    cursorOutline.style.border = '2px solid var(--primary)';
                    cursorOutline.style.backgroundColor = 'transparent';
                });
            });

            /* hide when leaving the window */
            document.addEventListener('mouseout', e => {
                if (!e.relatedTarget) {
                    cursor.style.display = cursorOutline.style.display = 'none';
                }
            });
            document.addEventListener('mouseover', () => {
                cursor.style.display = cursorOutline.style.display = 'block';
            });
        }
        // Initialize particles background
        function initParticles() {
            particlesJS('particles-js', {
                particles: {
                    number: {
                        value: 50,
                        density: {
                            enable: true,
                            value_area: 800
                        }
                    },
                    color: {
                        value: '#00c851'
                    },
                    shape: {
                        type: 'circle',
                        stroke: {
                            width: 0,
                            color: '#000000'
                        },
                        polygon: {
                            nb_sides: 5
                        }
                    },
                    opacity: {
                        value: 0.5,
                        random: true,
                        anim: {
                            enable: true,
                            speed: 1,
                            opacity_min: 0.1,
                            sync: false
                        }
                    },
                    size: {
                        value: 3,
                        random: true,
                        anim: {
                            enable: true,
                            speed: 2,
                            size_min: 0.1,
                            sync: false
                        }
                    },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: '#00c851',
                        opacity: 0.2,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 2,
                        direction: 'none',
                        random: true,
                        straight: false,
                        out_mode: 'bounce',
                        bounce: false,
                        attract: {
                            enable: false,
                            rotateX: 600,
                            rotateY: 1200
                        }
                    }
                },
                interactivity: {
                    detect_on: 'canvas',
                    events: {
                        onhover: {
                            enable: true,
                            mode: 'grab'
                        },
                        onclick: {
                            enable: true,
                            mode: 'push'
                        },
                        resize: true
                    },
                    modes: {
                        grab: {
                            distance: 140,
                            line_linked: {
                                opacity: 0.8
                            }
                        },
                        push: {
                            particles_nb: 4
                        }
                    }
                },
                retina_detect: true
            });
        }

        // Setup navigation behavior
        function setupNavigation() {
            const header = document.querySelector('header');
            const hamburgerMenu = document.querySelector('.hamburger-menu');
            const navLinks = document.querySelector('.nav-links');
            const navLinksItems = document.querySelectorAll('.nav-link');

            // Change header on scroll
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });

            hamburgerMenu.addEventListener('click', function() {
                navLinks.classList.toggle('show');

                // Optional: Animate hamburger menu into an X
                const bars = document.querySelectorAll('.hamburger-menu .bar');
                bars.forEach(bar => {
                    bar.classList.toggle('active');
                });
            });
            const style = document.createElement('style');
            style.textContent = `
        .hamburger-menu .bar.active:nth-child(1) {
            transform: translateY(8.5px) rotate(45deg);
        }
        .hamburger-menu .bar.active:nth-child(2) {
            opacity: 0;
        }
        .hamburger-menu .bar.active:nth-child(3) {
            transform: translateY(-8.5px) rotate(-45deg);
        }
    `;
            document.head.appendChild(style);

            // Close mobile menu when a link is clicked
            navLinksItems.forEach(item => {
                item.addEventListener('click', function() {
                    hamburgerMenu.classList.remove('active');
                    navLinks.classList.remove('show');
                });
            });
            document.addEventListener('click', function(event) {
                if (!hamburgerMenu.contains(event.target) && !navLinks.contains(event.target) && navLinks.classList
                    .contains('show')) {
                    navLinks.classList.remove('show');
                    bars.forEach(bar => {
                        bar.classList.remove('active');
                    });
                }
            });
            const navLinkItems = document.querySelectorAll('.nav-link');
            navLinkItems.forEach(link => {
                link.addEventListener('click', function() {
                    if (navLinks.classList.contains('show')) {
                        navLinks.classList.remove('show');
                        bars.forEach(bar => {
                            bar.classList.remove('active');
                        });
                    }
                });
            });
            // Active link on scroll
            window.addEventListener('scroll', function() {
                let current = '';
                const sections = document.querySelectorAll('section');

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;

                    if (pageYOffset >= (sectionTop - sectionHeight / 3)) {
                        current = section.getAttribute('id');
                    }
                });

                navLinksItems.forEach(link => {
                    link.classList.remove('active');
                    const href = link.getAttribute('href');
                    if (href && href !== '#' && href.substring(1) === current) {
                        link.classList.add('active');
                    } else if (current === undefined && href === '#') {
                        link.classList.add('active');
                    }
                });
            });
        }
        const cursor = document.querySelector('.cursor-dot');
        const cursorOutline = document.querySelector('.cursor-outline');

        document.addEventListener('mousemove', function(e) {
            let x = e.clientX;
            let y = e.clientY;

            cursor.style.transform = `translate3d(${x}px, ${y}px, 0)`;
            cursorOutline.style.transform = `translate3d(${x}px, ${y}px, 0)`;
        });

        // Cursor effects on links and buttons
        const links = document.querySelectorAll('a, button, .feature-card, .form-control, .checkbox-container');

        links.forEach(link => {
            link.addEventListener('mouseenter', function() {
                cursor.style.transform = 'translate(-50%, -50%) scale(1.5)';
                cursorOutline.style.transform = 'translate(-50%, -50%) scale(1.5)';
                cursorOutline.style.border = '1px solid var(--primary)';
                cursorOutline.style.backgroundColor = 'rgba(0, 200, 81, 0.1)';
            });

            link.addEventListener('mouseleave', function() {
                cursor.style.transform = 'translate(-50%, -50%) scale(1)';
                cursorOutline.style.transform = 'translate(-50%, -50%) scale(1)';
                cursorOutline.style.border = '2px solid var(--primary)';
                cursorOutline.style.backgroundColor = 'transparent';
            });
        });

        // Hide cursor and outline when mouse leaves window
        document.addEventListener('mouseout', function(e) {
            if (e.relatedTarget === null) {
                cursor.style.display = 'none';
                cursorOutline.style.display = 'none';
            }
        });

        document.addEventListener('mouseover', function() {
            cursor.style.display = 'block';
            cursorOutline.style.display = 'block';
        });


        // Setup form interactions
        function setupFormInteractions() {
            // File upload custom display
            const fileInput = document.getElementById('resume');

            if (fileInput) {
                const fileText = document.querySelector('.file-text');

                fileInput.addEventListener('change', function() {
                    if (fileInput.files.length > 0) {
                        fileText.textContent = fileInput.files[0].name;
                    } else {
                        fileText.textContent = 'Upload Resume (PDF, DOC)';
                    }
                });
            }

            // Password toggle visibility
            const passwordToggles = document.querySelectorAll('.password-toggle');

            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const passwordInput = this.previousElementSibling;
                    const icon = this.querySelector('i');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Application form submission
            const applicationForm = document.getElementById('applicationForm');

            if (applicationForm) {
                applicationForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Here you would typically send the form data to your server
                    // For demo purposes, we'll just show an alert
                    alert('Your application has been submitted successfully!');
                    applicationForm.reset();

                    // Scroll to top
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
        }

        // Setup testimonial slider
        function setupTestimonialSlider() {
            const track = document.querySelector('.testimonial-track');
            const dots = document.querySelectorAll('.dot');
            const prevBtn = document.querySelector('.control-prev');
            const nextBtn = document.querySelector('.control-next');

            if (!track || !dots.length || !prevBtn || !nextBtn) return;

            let currentSlide = 0;
            const slideWidth = 100; // 100%
            const totalSlides = document.querySelectorAll('.testimonial-card').length;

            // Set initial position
            updateSlider();

            // Event listeners for controls
            prevBtn.addEventListener('click', function() {
                currentSlide = (currentSlide > 0) ? currentSlide - 1 : totalSlides - 1;
                updateSlider();
            });

            nextBtn.addEventListener('click', function() {
                currentSlide = (currentSlide < totalSlides - 1) ? currentSlide + 1 : 0;
                updateSlider();
            });

            // Event listeners for dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', function() {
                    currentSlide = index;
                    updateSlider();
                });
            });

            // Auto slide change
            let slideInterval = setInterval(autoSlide, 5000);

            function autoSlide() {
                currentSlide = (currentSlide < totalSlides - 1) ? currentSlide + 1 : 0;
                updateSlider();
            }

            // Pause auto slide on hover
            track.addEventListener('mouseenter', function() {
                clearInterval(slideInterval);
            });

            track.addEventListener('mouseleave', function() {
                slideInterval = setInterval(autoSlide, 5000);
            });

            // Update slider position and active dot
            function updateSlider() {
                track.style.transform = `translateX(-${currentSlide * slideWidth}%)`;

                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentSlide);
                });
            }
        }

        // Setup authentication modals
        function setupAuthModals() {
            const loginBtn = document.getElementById('loginBtn');
            const signupBtn = document.getElementById('signupBtn');
            const closeLogin = document.getElementById('closeLogin');
            const closeSignup = document.getElementById('closeSignup');
            const loginModal = document.getElementById('loginModal');
            const signupModal = document.getElementById('signupModal');
            const switchToSignup = document.getElementById('switchToSignup');
            const switchToLogin = document.getElementById('switchToLogin');
            const loginForm = document.getElementById('loginForm');
            const signupForm = document.getElementById('signupForm');

            // Show login modal
            if (loginBtn && loginModal) {
                loginBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    showModal(loginModal);
                });
            }

            // Show signup modal
            if (signupBtn && signupModal) {
                signupBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    showModal(signupModal);
                });
            }

            // Close login modal
            if (closeLogin && loginModal) {
                closeLogin.addEventListener('click', function() {
                    hideModal(loginModal);
                });
            }

            // Close signup modal
            if (closeSignup && signupModal) {
                closeSignup.addEventListener('click', function() {
                    hideModal(signupModal);
                });
            }

            // Switch to signup
            if (switchToSignup && loginModal && signupModal) {
                switchToSignup.addEventListener('click', function(e) {
                    e.preventDefault();
                    hideModal(loginModal);
                    setTimeout(() => {
                        showModal(signupModal);
                    }, 300);
                });
            }

            // Switch to login
            if (switchToLogin && signupModal && loginModal) {
                switchToLogin.addEventListener('click', function(e) {
                    e.preventDefault();
                    hideModal(signupModal);
                    setTimeout(() => {
                        showModal(loginModal);
                    }, 300);
                });
            }

            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target.classList.contains('modal-overlay')) {
                    if (loginModal && loginModal.classList.contains('show')) {
                        hideModal(loginModal);
                    }
                    if (signupModal && signupModal.classList.contains('show')) {
                        hideModal(signupModal);
                    }
                }
            });

            // Login form submission
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Get form values
                    const email = document.getElementById('loginEmail').value;
                    const password = document.getElementById('loginPassword').value;

                    // Here you would typically validate and authenticate the user
                    // For demo purposes, we'll just set the user as logged in
                    localStorage.setItem('isLoggedIn', 'true');

                    // Close modal
                    hideModal(loginModal);

                    // Update UI
                    checkLoginStatus();

                    // Show success message
                    alert('You have been logged in successfully.');
                });
            }

            // Signup form submission
            if (signupForm) {
                signupForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Get form values
                    const name = document.getElementById('signupName').value;
                    const email = document.getElementById('signupEmail').value;
                    const password = document.getElementById('signupPassword').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;

                    // Basic validation
                    if (password !== confirmPassword) {
                        alert('Passwords do not match.');
                        return;
                    }

                    // Here you would typically register the user in your system
                    // For demo purposes, we'll just set the user as logged in
                    localStorage.setItem('isLoggedIn', 'true');

                    // Close modal
                    hideModal(signupModal);

                    // Update UI
                    checkLoginStatus();

                    // Show success message
                    alert('Your account has been created and you are now logged in.');
                });
            }

            // Show modal helper function
            function showModal(modal) {
                modal.style.display = 'flex';
                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            // Hide modal helper function
            function hideModal(modal) {
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            }
        }

        // Parallax effect for background elements
        window.addEventListener('scroll', function() {
            const scrollPosition = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.parallax-bg');

            parallaxElements.forEach(element => {
                const speed = 0.5;
                element.style.transform = `translateY(${scrollPosition * speed}px)`;
            });
        });

        // Interactive 3D tilt effect for feature cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.feature-card');

            cards.forEach(card => {
                card.addEventListener('mousemove', function(e) {
                    const cardRect = card.getBoundingClientRect();
                    const x = e.clientX - cardRect.left;
                    const y = e.clientY - cardRect.top;

                    const centerX = cardRect.width / 2;
                    const centerY = cardRect.height / 2;

                    const rotateX = (y - centerY) / 20;
                    const rotateY = (centerX - x) / 20;

                    this.style.transform =
                        `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.05, 1.05, 1.05)`;
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform =
                        'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
                });
            });
        });

        // Animated counter for statistics
        function animateCounter(element, target, duration) {
            const start = 0;
            const increment = target / (duration / 16);
            let current = start;

            const timer = setInterval(function() {
                current += increment;

                if (current >= target) {
                    element.textContent = Math.round(target);
                    clearInterval(timer);
                    return;
                }

                element.textContent = Math.round(current);
            }, 16);
        }

        // Start counter animation when elements are in viewport
        document.addEventListener('DOMContentLoaded', function() {
            const statNumbers = document.querySelectorAll('.stat-number');
            const options = {
                threshold: 0.7
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = parseInt(entry.target.textContent);
                        animateCounter(entry.target, target, 2000);
                        observer.unobserve(entry.target);
                    }
                });
            }, options);

            statNumbers.forEach(stat => {
                observer.observe(stat);
            });
        });

        // Lazy loading images with blur effect
        document.addEventListener('DOMContentLoaded', function() {
            const lazyImages = document.querySelectorAll('img[data-src]');

            const options = {
                rootMargin: '0px',
                threshold: 0.1
            };

            const imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const src = img.getAttribute('data-src');

                        img.setAttribute('src', src);
                        img.classList.add('fade-in');
                        imageObserver.unobserve(img);
                    }
                });
            }, options);

            lazyImages.forEach(image => {
                imageObserver.observe(image);
            });
        });

        // Typed.js effect for hero title
        document.addEventListener('DOMContentLoaded', function() {
            const heroTitle = document.querySelector('.animated-title .animated-text');

            if (heroTitle && typeof Typed !== 'undefined') {
                new Typed(heroTitle, {
                    strings: ['Launch Your Career in'],
                    typeSpeed: 50,
                    showCursor: false,
                    onComplete: function() {
                        const highlightText = document.querySelector('.animated-title .highlight');
                        if (highlightText) {
                            new Typed(highlightText, {
                                strings: ['Cloud Technology'],
                                typeSpeed: 50,
                                showCursor: false
                            });
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
