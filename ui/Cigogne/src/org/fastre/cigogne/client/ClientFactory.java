/**
 * 
 */
package org.fastre.cigogne.client;


import com.google.gwt.place.shared.PlaceController;
import com.google.web.bindery.event.shared.EventBus;
import com.google.web.bindery.event.shared.SimpleEventBus;

/**
 * @author Julien Fastré
 *
 */
public class ClientFactory {
	
	private final EventBus eventBus = new SimpleEventBus();
    private final PlaceController placeController = new PlaceController(eventBus);

	
	public EventBus getEventBus()
	{
		return this.eventBus;
	}
	
}
