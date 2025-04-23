import { h } from 'vue'
import type { ColumnDef } from '@tanstack/vue-table'

interface Floor {
  id: number;
  name: string;
  number: number;
  creator?: {
    name: string;
  };
}

export const getColumns = (
  editFloor: (id: number) => void,
  confirmDelete: (id: number) => void
): ColumnDef<Floor>[] => [
  {
    accessorKey: 'name',
    header: () => h('div', { class: 'text-left' }, 'Name'),
    cell: ({ row }) => h('div', { class: 'text-left' }, row.getValue('name')),
  },
  {
    accessorKey: 'number',
    header: () => h('div', { class: 'text-left' }, 'Number'),
    cell: ({ row }) => h('div', { class: 'text-left' }, row.getValue('number')),
  },
  {
    accessorKey: 'creator.name',
    // if 'isAdmin'
    header: () => h('div', { class: 'text-left' }, 'Manager Name'),
    cell: ({ row }) => {
      const creator = row.original.creator
      return h('div', { class: 'text-left' }, creator?.name || 'Not Available')
    },
  },
  {
    id: 'actions',
    header: () => h('div', { class: 'text-center' }, 'Actions'),
    cell: ({ row }) => {
      const floor = row.original
      // if 'isManager'
      return h('div', { class: 'flex justify-center space-x-2' }, [
        h(
          'button',
          {
            class: 'text-blue-600 hover:text-blue-800',
            onClick: () => editFloor(floor.id),
          },
          'Edit'
        ),
        h(
          'button',
          {
            class: 'text-red-600 hover:text-red-800',
            onClick: () => confirmDelete(floor.id),
          },
          'Delete'
        ),
      ])
    },
  },
]