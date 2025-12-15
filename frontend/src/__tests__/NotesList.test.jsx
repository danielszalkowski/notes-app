import { render, screen, waitFor } from '@testing-library/react'
import NotesList from '../components/NotesList'
import { BrowserRouter } from 'react-router-dom'
import axios from 'axios'
import { vi } from 'vitest'

vi.mock('axios')

test('renders notes list component', async () => {
    axios.get.mockResolvedValue({
        data: {
            data: [
                { id: 1, title: 'nueva nota', content: 'contenido' },
                { id: 2, title: 'otra nota', content: 'contenido 2' }
            ],
            meta: {
                current_page: 1,
                last_page: 1,
                total: 2
            }
        }
    })

    render(
        <BrowserRouter>
            <NotesList />
        </BrowserRouter>
    )

    const noteTitle = await screen.findByRole('heading', { name: /nueva nota/i, level: 3 })
    expect(noteTitle).toBeInTheDocument()

    const noteTitle2 = await screen.findByRole('heading', { name: /otra nota/i, level: 3 })
    expect(noteTitle2).toBeInTheDocument()

})
