import { useEffect, useState } from "react"

export default function useUserData() {
    const [userDataIndex, setUserDataIndex] = useState(localStorage.getItem('user_data_index'));
    const [userData, setUserData] = useState(localStorage.getItem('user_data') ? JSON.parse(localStorage.getItem('user_data')).results[userDataIndex] : null);

    useEffect(() => {
        const userDataFromStorage = JSON.parse(localStorage.getItem('user_data'));
        if (userDataFromStorage && userDataFromStorage.results) {
            setUserData(userDataFromStorage.results[userDataIndex]);
        }
    }, [userDataIndex]);

    return { userData, setUserDataIndex };
  };