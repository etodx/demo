import {useEffect, useState} from 'react'

interface jsonorders{
    orders:Order[]
}

interface Order {
    id:number,
    room:string,
    price:string
    payment_type:'По карте'|'По номеру телефона',
    date:number,
    status:'Новая'|'Мероприятие назначено'|'Мероприятие завершено',
}

interface UserType {
    user_type:'user'|'admin'
}

function App () {
    const [type, setType] = useState<UserType>({user_type:'user'})
    useEffect(()=>{
        (async ()=>{
            const res = await fetch('/type')
            if(!res.ok) throw new Error
            const data = await res.json()
            setType(data)
        })()
    })
    if(type.user_type=='admin'){
        return <Admin />
    }else{
        return <User />
    }
}
function User () {
    const [orders, setorders] = useState<jsonorders>()
    const [isReviewsShown, setIsReviewsShown] = useState(false)
    useEffect(()=>{
        (async ()=>{
            const res = await fetch('/orders')
            if(!res.ok) throw new Error
            const data = await res.json()
            setorders(data)
        })()
    })

    function showReviewForm (){
        setIsReviewsShown(prev=>!prev)
    }
    if(orders){
    return(
        <div>
            {orders.orders.map((order,index)=>(
                <div key={index}>
            <div>{order.id}</div>
            <div>{order.date}</div>
            <div>{order.room}</div>
            <div>{order.price}</div>
            <div>{order.payment_type}</div>
            <div>{order.status}</div>
            {order.status=='Мероприятие завершено' && (
                 <button onClick={()=>{showReviewForm()}}>Оставить отзыв</button>
            )}
                </div>
            ))}
            {isReviewsShown && (
                <Review />
            )}
        </div>
    )
}
}
function Review (){
    return(
        <div>
            Оставьте отзыв:
            <form action='/postReview'>
                <input id='rating'></input>
                <input id='review'></input>
                <button type='submit'></button>
            </form>
        </div>
    )
}

function Admin () {
    const [orders, setorders] = useState<jsonorders>()
    useEffect(()=>{
        (async ()=>{
            const res = await fetch('/orders')
            if(!res.ok) throw new Error
            const data = await res.json()
            setorders(data)
        })()
    })
    if(orders){
    return(
        <div>
            {orders.orders.map((order,index)=>(
            <div key={index}>
            <div>{order.id}</div>
            <div>{order.date}</div>
            <div>{order.room}</div>
            <div>{order.price}</div>
            <div>{order.payment_type}</div>
            <div>{order.status}</div>
            <button hidden={order.status!='Мероприятие завершено'}>{order.status=='Новая'?'Одобрить мероприятие':order.status=='Мероприятие назначено'?'Завершить мероприятие':1}</button>
                </div>
            ))}
        </div>
    )
}
}
export default App;