export default function ActivityCard({ icon, text }) {
    return <div className="flex items-center">
        <i data-lucide={icon} className="text-indigo-500 mr-2 ml-5" style={{ width: '20px', height: '20px' }}></i>
        <div className="text-sm font-smaller text-gray-900">{text}</div>
    </div>
}