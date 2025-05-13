import './css/main.css';
import { createBrowserRouter, RouterProvider } from 'react-router';

import PageError from './errors/PageError';

import Root from './components/Root/Root';

import Home from './components/Home/Home';
import Dashboard from './components/Dashboard/Dashboard';


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
      }
    ]
  }
], {
  basename: '/',
})

export default function App() {
  return <RouterProvider router={router} />;
}
