import './css/main.css';
import { createBrowserRouter, RouterProvider } from 'react-router';

import PageError from './errors/PageError';

import Root from './components/Root/Root';

import Home from './components/Home/Home';
import Dashboard from './components/Dashboard/Dashboard';
import Activities from './components/Activities/Activities';
import Login from './components/Account/Login';


const router = createBrowserRouter([
  {
    path: '/',
    element: <Root />,
    errorElement: <PageError />,
    children: [  
      { 
        path: '',
        element: <Home />,
      },
      {
        path: 'dashboard',
        element: <Dashboard />
      },
      {
        path: 'activities',
        element: <Activities />
      },
      {
        path: 'login',
        element: <Login />
      }
    ]
  }
], {
  basename: '/',
})

export default function App() {
  return <RouterProvider router={router} />;
}
