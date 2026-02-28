import {useEffect, useState} from 'react'

interface jsonRooms{
    
}
function App () {
    const [rooms, setRooms] = useState()


    useEffect(()=>{
        (async ()=>{
            const res = await fetch('')
            if(!res.ok) throw new Error
            const data = res.json()
            setRooms(data)
        })()
    })
    return(
        <div></div>
    )
}