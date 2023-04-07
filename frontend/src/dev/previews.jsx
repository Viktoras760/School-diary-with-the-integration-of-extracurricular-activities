import React from 'react'
import { ComponentPreview, Previews } from '@react-buddy/ide-toolbox'
import { PaletteTree } from './palette'
import Register from '../Views/Register'

const ComponentPreviews = () => {
  return (
        <Previews palette={<PaletteTree/>}>
            <ComponentPreview path="/Register">
                <Register/>
            </ComponentPreview>
        </Previews>
  )
}

export default ComponentPreviews
