import { useRouteError, Link } from "react-router";

import Navbar from "../components/Root/Navbar";
import Footer from "../components/Root/Footer";

export default function PageError() {
    const error = useRouteError()
  
    return (<>
      <div id="scrolltop"></div>
      <header>
          <Navbar />
      </header>
      <div id="error-page">
          <p>Désolé, une erreur inattendue est survenue.</p>
          <p>
            {error && <i>{error.status} {error.statusText || error.message}</i>}
          </p>
          <Link to=''>Retour à l'accueil</Link>
      </div>
      <footer>
          <Footer />
      </footer>
  </>);
}
  