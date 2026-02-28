import {useEffect, useState} from 'react'
interface Rooms{
    rooms:Room[]
}
interface Room {
    id:number,
    room_type:string,
    price:number,
    capacity:number
}

function App () {
    const [rooms, setRooms] = useState<Rooms>()
        useEffect(()=>{
            (async ()=>{
                const res = await fetch('/rooms')
                if(!res.ok) throw new Error
                const data = await res.json()
                setRooms(data)
            })()
        })
    if(rooms){
        return(
            <div>
                {rooms.rooms.map((room, index)=>(
                    <div key={index}>
                        <div>{room.room_type}</div>
                        <div>{room.capacity}</div>
                        <div>{room.price}</div>
                    </div>
                ))}
            </div>
        )
    }
}

function PlaceOrder (room:Room, id:number) {
    const [sendArray, setSendArray] = useState({
        room_id:id,
        payment_type:'',
        date:'',
        status:'Новая'
    })
    function handleChange(evt:React.ChangeEvent<HTMLInputElement>){
        const {name, value} = evt.target
        if(name=='pt'){
            setSendArray(prev=>({
                ...prev,
                'payment_type':value
            }))
        }else{
            setSendArray(prev=>({
                ...prev,
                'date':value
            }))
        }
    }
    async function handleSubmit(){
        const res = await fetch('/order',
            {
            method:"POST",
                headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(sendArray)
            }
        )
        if(!res.ok) throw new Error
        const data = await res.json()
console.log(data)
    }
    return(
        <div>
            <div>
                <div>Вы выбрали: {room.room_type}</div>
                <div>Со вместимостью: {room.capacity}</div>
                <div>И ценой: {room.price}</div>
                </div>
            <form>
                <input name='date' type='date' onChange={handleChange}></input>
                <input name='pt' type='text' onChange={handleChange}></input>
                <button onClick={()=>{handleSubmit()}}></button>
            </form>
        </div>
    )
}

export default App;
