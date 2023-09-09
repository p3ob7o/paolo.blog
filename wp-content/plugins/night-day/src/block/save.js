export default function Save( { attributes } ) {
    const { content, styleOption } = attributes;

    return (
        <div className={ `night-day-block ${ styleOption }` }>
            <p>{ content }</p>
        </div>
    );
}
