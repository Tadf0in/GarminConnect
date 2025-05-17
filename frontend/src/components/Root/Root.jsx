import React, { useEffect } from 'react';
import Navbar from './Navbar';
import Footer from './Footer';
import { Outlet, useLocation } from 'react-router';

export default function Root() {
    const { pathname } = useLocation();

    useEffect(() => {
        document.getElementById('scrolltop').scrollIntoView();
    }, [pathname]);

    return (<>
        <div id="scrolltop"></div>
        <header>
            <Navbar />
        </header>
        <div className='Outlet'>
            <Outlet />
        </div>
        <footer>
            <Footer />
        </footer>
    </>);
}