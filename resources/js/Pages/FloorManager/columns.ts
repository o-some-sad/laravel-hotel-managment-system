import { h } from 'vue'
import type { ColumnDef } from '@tanstack/vue-table'

interface Floor {
  id: number;
  name: string;
  number: number;
  creator?: {
    id: number,
    name: string;
  };
}

export const getColumns = (
  editFloor: (id: number) => void,
  confirmDelete: (id: number) => void,
  isAdmin: boolean = false,
  isManager: boolean = false,
  userId: number = 0
): ColumnDef<Floor>[] => {
  const columns: ColumnDef<Floor>[] = [
    {
      accessorKey: 'name',
      header: () => h('div', { class: 'text-center' }, 'Name'),
      cell: ({ row }) => h('div', { class: 'text-center' }, row.getValue('name')),
    },
    {
      accessorKey: 'number',
      header: () => h('div', { class: 'text-center' }, 'Number'),
      cell: ({ row }) => h('div', { class: 'text-center' }, row.getValue('number')),
    }
  ];

  // ONLY show manager name column for admins
  if (isAdmin) {
    columns.push({
      accessorKey: 'creator.name',
      header: () => h('div', { class: 'text-center' }, 'Manager Name'),
      cell: ({ row }) => {
        const creator = row.original.creator
        return h('div', { class: 'text-center' }, creator?.name || 'Not Available')
      },
    });
  }

  // Add actions column if user is a manager (for their own floors)
  if (isManager) {
  columns.push({
    id: 'actions',
    header: () => h('div', { class: 'text-center' }, 'Actions'),
    cell: ({ row }) => {
      const floor = row.original

      // console.log('Floor Creator:', floor.creator);
      // console.log('Floor Creator ID:', floor.creator?.id);
      // console.log('Current User ID:', userId);
      // console.log('Is Manager:', isManager);
    
      // Only show edit/delete buttons if:
      // - User is the manager who created this floor
      const canManage = isManager && floor.creator && floor.creator.id === userId;
      if (!canManage) {
        return h('div', { class: 'text-gray-400 flex justify-center space-x-2' },['Only creator can edit/delete'])
        }

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
  });
}

  return columns;
}