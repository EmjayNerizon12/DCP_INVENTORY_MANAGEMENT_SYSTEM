<style>
    html {
        scroll-behavior: smooth;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    [x-cloak] {
        display: none !important;
    }

    /* Target the element you want to scroll */
    .scrollable-element {
        overflow-y: auto;
        /* enable vertical scrolling */
        max-height: 400px;
        /* optional, for demo */
    }

    /* WebKit scrollbar styles */
    .scrollable-element::-webkit-scrollbar {
        width: 4px;
        /* super thin width */
        height: 4px;
        /* for horizontal scrollbar if needed */
    }

    .scrollable-element::-webkit-scrollbar-track {
        background: transparent;
        /* optional: track background */
    }

    .scrollable-element::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.5);
        /* thumb color */
        border-radius: 10px;
        /* rounded edges */
    }

    .scrollable-element::-webkit-scrollbar-thumb:hover {
        background-color: rgba(0, 0, 0, 0.7);
        /* hover effect */
    }


    .division-name {
        font-family: 'Trajan Pro', 'Times New Roman', serif;

        letter-spacing: 2px;

        margin: 0;
        line-height: 1.2;
    }

    .san-carlos {
        font-family: 'Times New Roman', serif;
        letter-spacing: 1px;
        text-align: left;

        line-height: 1.2;
    }

    .user-profile-btn {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 30px;
        color: white;
        display: flex;
        align-items: center;
        padding: 5px 15px 5px 5px;
        transition: all 0.2s;
    }

    .user-profile-btn:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    .user-profile-btn img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-right: 10px;
        border: 2px solid rgba(255, 255, 255, 0.5);
    }

    .user-profile-btn .user-name {
        font-weight: 500;
        margin-right: 5px;
        max-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Responsive adjustments */

    /* --- SIDEBAR BASE --- */
    .sidebar {
        position: fixed;
        top: 50;
        left: 0;
        height: 100vh;
        width: 280px;
        box-shadow: 0 0 10px rgba(15, 23, 42, 0.08);
        overflow-y: auto;
        transition: left 0.5s eas e;
        /* ONLY LEFT! */
        z-index: 50;
        background-color: #ffffff;
        color: #1f2937;
        overflow-y: scroll;
        /* keeps scroll functionality */
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* IE/Edge */
        border-right: 1px solid #e5e7eb;
    }

    .sidebar::-webkit-scrollbar {
        display: none;
        /* Chrome/Safari */
    }

    .sidebar.hidden {
        left: -280px;
        /* slide out */
    }

    .main-content {
        padding: 100px 40px 40px;
        width: 100% !important;
        margin-left: 250px;
        transition: margin-left 0.55s ease;
        /* match sidebar */
    }

    .sidebar.hidden~.main-content {
        margin-left: 0;
        /* shift main content when hidden */
    }

    .sidebar-title {
        background: #f8fafc;
        color: #1e3a8a;
        border: 1px solid #dbeafe;
        box-shadow: none;
        letter-spacing: 0.05rem;
    }

    .title-icon {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #2563eb;
        color: #ffffff;
        border-radius: 8px;
        box-shadow: none;
        flex-shrink: 0;
    }


    .nav-link {
        padding: 0.7rem 1rem;
        border-radius: 12px;
        margin: 0.25rem 1rem;
        transition: all 0.3s ease;
        display: flex;
        letter-spacing: 0.05rem;
        align-items: center;
        white-space: nowrap;
        position: relative;
        font-family:'Segoe UI', Verdana, sans-serif;
        text-decoration: none;
        color: #374151;
    }


    .nav-link:hover {
        background: #eff6ff;
        color: #1d4ed8;
        transform: none;
        box-shadow: none;
        text-decoration: none;
    }
    .nav-link.active {
        background: #2F6FE4;
        color: #ffffff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.05rem;
        border: 1px solid #2F6FE4;
        border-radius: 12px;
        box-shadow: none;
        transform: none;
    }

    .nav-link svg {
        margin-right: 14px;
        width: 22px;
        height: 22px;
        opacity: 0.9;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .sidebar.collapsed .nav-link svg {
        margin-right: 0;
    }

    .nav-link:hover svg,
    .nav-link.active svg {
        opacity: 1;
        transform: none;
    }




    @media (max-width: 768px) {

        .navbar-brand {
            font-size: 1.2rem;
        }

        .user-profile-btn .user-name {
            display: none;
        }

        .user-profile-btn {
            padding: 5px;
        }
    }


    /* --- MOBILE --- */
    @media (max-width: 992px) {
        .sidebar {
            left: -280px;
            transition: left 0.55s ease;
            /* same speed */
        }

        .sidebar.show {
            left: 0;
            /* slide in */
        }

        .main-content {
            margin-left: 0;
            padding: 90px 0px 0px;

            /* main content doesn't move on mobile */
            transition: none;
        }
    }
</style>
