

function initializeEnum(enumName, decoratorCallback)
{
  // make all the initial instances as well as the prototype interactive
  decorateInstances(enumName, decoratorCallback);


  // move prototype out of the DOM tree into a global variable

  var prototype = getPrototype(enumName); 

  if(typeof(window.prototype) == 'undefined') {
    window.prototype = new Array();
  }

  window.prototype[enumName] = prototype.detach();

    return true;
}

function getPrototype(enumName)
{
  var isGlobalDefined = typeof(window.prototype) != 'undefined';
  var isEnumInitialized = isGlobalDefined && window.prototype[enumName];

  if(isEnumInitialized) return window.prototype[enumName];

  return getEnum(enumName)
         .children( '.gira_enum_instance.gira_enum_prototype' );
}

function getEnum(enumName) {
  return $('#gira_enum_' + enumName);
}


function decorateInstances(enumName, decoratorCallback)
{
  // decorate the prototype separately
  //decoratorCallback(window.prototype[enumName]);

  childrenContainers = getAll(enumName);

  childrenContainers.each( function() {
    decoratorCallback( this );

  } );

}


function getAll(enumName)
{
  var childrenContainers = getEnum(enumName).children('.gira_enum_instance');
  var prototype = getPrototype(enumName);

  return $( childrenContainers ).add(prototype);
}


function createNewEnumInstance(enumName)
{
  var newInstance =  $(window.prototype[enumName]).clone(true );

  newInstance.removeClass('gira_enum_prototype');

  return newInstance;
}

function addIndices(enumName)
{
  var instanceContainers = getEnum(enumName).find('.gira_enum_instance');

  // TODO global index!
  var currentIndex = 1;

  instanceContainers.each( function(index, element) {

    var elementsWithNameAttribute = $( element ).find('[name]');
    elementsWithNameAttribute .each( function(index, elementWithName) {
      var name = $( elementWithName ).attr('name');
      name = name.replace(/\$\$\$\$\$/g, currentIndex);

      $( elementWithName ).attr('name', name);

    });

    currentIndex++;
  });

  return true;
}












